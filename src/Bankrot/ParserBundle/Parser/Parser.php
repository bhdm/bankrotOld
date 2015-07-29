<?php

namespace Bankrot\ParserBundle\Parser;

use Bankrot\ParserBundle\Entity\Area;
use Bankrot\ParserBundle\Entity\Attr;
use Bankrot\ParserBundle\Entity\AttrGroup;
use Bankrot\ParserBundle\Entity\Content;
use Bankrot\ParserBundle\Entity\ContentGroup;
use Bankrot\ParserBundle\Entity\Cost;
use Bankrot\ParserBundle\Entity\CostGroup;
use Bankrot\ParserBundle\Entity\Date;
use Bankrot\ParserBundle\Entity\DateGroup;
use Bankrot\ParserBundle\Entity\Debtor;
use Bankrot\ParserBundle\Entity\Lot;
use Bankrot\ParserBundle\Entity\PriceType;
use Bankrot\ParserBundle\Entity\Status;
use Bankrot\ParserBundle\Entity\Type;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;

class Parser
{
    /** @var EntityManager $em */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function sync(Callable $iterationCb = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://bankrot.fedresurs.ru/TradeList.aspx');
        curl_setopt($ch, CURLOPT_USERAGENT, UserAgentGenerator::get());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $r = iconv('utf8', 'cp1251', curl_exec($ch));
        curl_close($ch);

        // {{{
        /*$conn = $this->em->getConnection();

        $conn->query('SET foreign_key_checks = 0');
        $conn->query('TRUNCATE TABLE areas');
        $conn->query('TRUNCATE TABLE attr_groups');
        $conn->query('TRUNCATE TABLE attrs');
        $conn->query('TRUNCATE TABLE content_groups');
        $conn->query('TRUNCATE TABLE contents');
        $conn->query('TRUNCATE TABLE cost_groups');
        $conn->query('TRUNCATE TABLE costs');
        $conn->query('TRUNCATE TABLE date_groups');
        $conn->query('TRUNCATE TABLE dates');
        $conn->query('TRUNCATE TABLE debtors');
        $conn->query('TRUNCATE TABLE lots');
        $conn->query('TRUNCATE TABLE price_types');
        $conn->query('TRUNCATE TABLE statuses');
        $conn->query('TRUNCATE TABLE types');
        $conn->query('SET foreign_key_checks = 1');*/
        // }}}

        $crawler = new Crawler($r);
        $crawler
            ->filter('#ctl00_cphBody_upTradeList tr')
            ->reduce(
                function (Crawler $sets, $i) use ($iterationCb) {
                    if (!preg_match('~<td[^>]*>[\s\d\.:]+</td>~ms', $sets->html())) {
                        return;
                    }
                    $lot = new Lot();
                    $sets
                        ->filter('td')
                        ->reduce(
                            function (Crawler $set, $j) use (& $lot, $iterationCb) {
                                $raw = trim($set->html());

                                switch ($j) {
                                    case 0:
                                        $lot->setNumber($raw);

                                        break;

                                    case 1:
                                        $lot->setBidAt(new \DateTime($raw));

                                        break;

                                    case 2:
                                        $lot->setCreatedAt(new \DateTime($raw));

                                        break;

                                    case 3:
                                        if (preg_match('/<a.*ID=([\d\w]+)[^>]+>([^<]+)<\/a>/', $raw, $m)) {
                                            if (!$area = $this->em->getRepository(
                                                'BankrotParserBundle:Area'
                                            )->findOneByRemoteId($m[1])
                                            ) {
                                                $area = new Area();
                                                $area->setRemoteId($m[1]);
                                                $area->setName(trim($m[2]));
                                                //TODO Вставить ссыль
                                                if ($link = $this->syncAreaUrl($m[1])) {
                                                    $area->setLink($link);
                                                };

                                                $this->em->persist($area);
                                                $this->em->flush();
                                            }

                                            $lot->setArea($area);
                                        }

                                        break;

                                    case 4:
                                        if (preg_match('/<a.*ID=([\d\w]+)[^>]+>([^<]+)<\/a>/', $raw, $m)) {
                                            if (!$debtor = $this->em->getRepository(
                                                'BankrotParserBundle:Debtor'
                                            )->findOneByRemoteId($m[1])
                                            ) {
                                                $debtor = new Debtor();
                                                $debtor->setRemoteId($m[1]);
                                                $debtor->setName(trim($m[2]));

                                                $this->em->persist($debtor);
                                                $this->em->flush();
                                            }

                                            $lot->setDebtor($debtor);
                                        }

                                        break;

                                    case 5:
                                        if (preg_match('/<a.*ID=([\d\w]+)[^>]+>([^<]+)<\/a>/', $raw, $m)) {
                                            $lot->setRemoteId($m[1]);

                                            if (!$type = $this->em->getRepository(
                                                'BankrotParserBundle:Type'
                                            )->findOneByName(trim($m[2]))
                                            ) {
                                                $type = new Type();
                                                $type->setName(trim($m[2]));

                                                $this->em->persist($type);
                                                $this->em->flush();
                                            }

                                            $lot->setType($type);
                                        }

                                        break;

                                    case 6:
                                        if (!$priceType = $this->em->getRepository(
                                            'BankrotParserBundle:PriceType'
                                        )->findOneByName($raw)
                                        ) {
                                            $priceType = new PriceType();
                                            $priceType->setName($raw);

                                            $this->em->persist($priceType);
                                            $this->em->flush();
                                        }

                                        $lot->setPriceType($priceType);

                                        break;

                                    case 7:
                                        if (!$status = $this->em->getRepository(
                                            'BankrotParserBundle:Status'
                                        )->findOneByName($raw)
                                        ) {
                                            $status = new Status();
                                            $status->setName($raw);

                                            $this->em->persist($status);
                                            $this->em->flush();
                                        }

                                        $lot->setStatus($status);

                                        break;
                                }
                            }
                        );

                    if (!$existLog = $this->em->getRepository('BankrotParserBundle:Lot')->findOneByRemoteId($lot->getRemoteId())) {
                        if ($iterationCb) {
                            $iterationCb($lot->getRemoteId());
                            $this->syncOnce($lot);
                            $this->em->persist($lot);
                        }
                    }
                }
            );

        $this->em->flush();
    }

    public function syncOnce(Lot $lot)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://bankrot.fedresurs.ru/TradeCard.aspx?ID='.$lot->getRemoteId());
        curl_setopt($ch, CURLOPT_USERAGENT, UserAgentGenerator::get());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $r = iconv('utf8', 'cp1251', curl_exec($ch));

        curl_close($ch);

        (new Crawler($r))
            ->filter('#ctl00_cphBody_tableTradeInfo tr')
            ->reduce(
                function (Crawler $sets, $i) use (& $lot) {
                    if (preg_match_all('~<td[^>]*>(.*?)</td>~s', $sets->html(), $mm)) {
                        $th = trim(strip_tags($mm[1][0]));
                        $td = trim(strip_tags($mm[1][1]));

                        $th_ = mb_strtolower($th, 'UTF-8');

                        if ($td) {
                            if (false !== strstr($th_, 'дата')) {
                                if (!$group = $this->em->getRepository(
                                    'BankrotParserBundle:DateGroup'
                                )->findOneByName($th)
                                ) {
                                    $group = new DateGroup();
                                    $group->setName($th);

                                    $this->em->persist($group);
                                    $this->em->flush();
                                }

                                $attr = new Date();
                                $attr->setGroup($group);
                                $attr->setVal(new \DateTime($td));
                                $attr->setLot($lot);

                                $this->em->persist($attr);
                                $this->em->flush();
                            } else {
                                if (!$group = $this->em->getRepository(
                                    'BankrotParserBundle:AttrGroup'
                                )->findOneByName($th)
                                ) {
                                    $group = new AttrGroup();
                                    $group->setName($th);

                                    $this->em->persist($group);
                                    $this->em->flush();
                                }

                                $attr = new Attr();
                                $attr->setGroup($group);
                                $attr->setVal($td);
                                $attr->setLot($lot);

                                $this->em->persist($attr);
                                $this->em->flush();
                            }
                        }
                    }
                }
            );

        (new Crawler($r))
            ->filter('#ctl00_cphBody_rptLotList_ctl00_tblTradeLot tr')
            ->reduce(
                function (Crawler $sets, $i) use (& $lot) {
                    if (preg_match_all('~<td[^>]*>(.*?)</td>~s', $sets->html(), $mm)) {
                        if (2 === count($mm[0])) {
                            $th = trim(strip_tags($mm[1][0]));
                            $td = trim(strip_tags($mm[1][1]));

                            $th_ = mb_strtolower($th, 'UTF-8');

                            if ($td) {
                                if (false === strstr($th_, 'руб')) {
                                    if (!$group = $this->em->getRepository(
                                        'BankrotParserBundle:AttrGroup'
                                    )->findOneByName($th)
                                    ) {
                                        $group = new AttrGroup();
                                        $group->setName($th);

                                        $this->em->persist($group);
                                        $this->em->flush();
                                    }

                                    $attr = new Attr();
                                    $attr->setGroup($group);
                                    $attr->setVal($td);
                                    $attr->setLot($lot);

                                    $this->em->persist($attr);
                                    $this->em->flush();
                                } else {
                                    if (!$group = $this->em->getRepository(
                                        'BankrotParserBundle:CostGroup'
                                    )->findOneByName($th)
                                    ) {
                                        $group = new CostGroup();
                                        $group->setName($th);

                                        $this->em->persist($group);
                                        $this->em->flush();
                                    }

                                    $td = str_replace(' ', '', $td);
                                    $td = str_replace(',', '.', $td);
                                    $td = (float)$td;

                                    $attr = new Cost();
                                    $attr->setGroup($group);
                                    $attr->setVal($td);
                                    $attr->setLot($lot);

                                    $this->em->persist($attr);
                                    $this->em->flush();
                                }
                            }
                        } else {
                            if (preg_match('~<b>([^<]+)</b>(.*)~s', $mm[1][0], $mmm)) {
                                $th = trim(strip_tags($mmm[1]));
                                $td = trim(strip_tags(preg_replace('/<br\s?\/?>/', str_repeat(PHP_EOL, 2), $mmm[2])));

                                if ('Предмет торгов' === $th) {
                                    $gr = explode(PHP_EOL, $td)[0];
                                    $gr = preg_replace('/([^а-яё\s-]|\bООО|\bот\b|\s{2,})/ui', '|', $gr);
                                    $gr = trim(explode('|', $gr)[0]);

                                    if (false === strpos($td, 'можно ознакомиться')) {
                                        $strlen = mb_strlen($gr, 'UTF-8');
                                        $firstChar = mb_substr($gr, 0, 1, 'UTF-8');
                                        $then = mb_substr($gr, 1, $strlen - 1, 'UTF-8');
                                        $gr = mb_strtoupper($firstChar, 'UTF-8').$then;

                                        var_dump($gr);
                                    }
                                }

//                                if (preg_match('~<a.*?openNewWin\(\'([^\']+)~s', $mmm[2], $m)) {
//                                    $url = $m[1];
//
//                                    if (false !== strpos($url, 'TradeObject')) {
//                                        $ch = curl_init();
//
//                                        curl_setopt($ch, CURLOPT_URL, 'http://bankrot.fedresurs.ru/TradeList.aspx');
//                                        curl_setopt($ch, CURLOPT_USERAGENT, UserAgentGenerator::get());
//                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//                                        $r = iconv('utf8', 'cp1251', curl_exec($ch));
//
//                                        curl_close($ch);
//
//                                        if (preg_match('~<td style="padding:[^"]+">(.*?)</td>~s', $r, $m)) {
//                                            $td = trim($m[1]);
//                                        }
//                                    }
//                                }

                                if (!$group = $this->em->getRepository(
                                    'BankrotParserBundle:ContentGroup'
                                )->findOneByName($th)
                                ) {
                                    $group = new ContentGroup();
                                    $group->setName($th);

                                    $this->em->persist($group);
                                    $this->em->flush();
                                }

                                $attr = new Content();
                                $attr->setGroup($group);
                                $attr->setVal($td);

                                $attr->setLot($lot);

                                $this->em->persist($attr);
                                $this->em->flush();
                            }
                        }
                    }
                }
            );
    }

    //Забирает урл площадки
    private function syncAreaUrl($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://bankrot.fedresurs.ru/TradePlaceCard.aspx?ID='.$id);
        curl_setopt($ch, CURLOPT_USERAGENT, UserAgentGenerator::get());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $r = iconv('utf8', 'cp1251', curl_exec($ch));

        curl_close($ch);
        $crawler = new Crawler($r);
        $html=  trim($crawler
            ->filter('#ctl00_cphBody_aTradeSite')
            ->html()
        );
        if (!preg_match('/^http:\\/\\//',$html)) {
            $html = 'http://'.$html;
        }
        return $html;

    }
}
