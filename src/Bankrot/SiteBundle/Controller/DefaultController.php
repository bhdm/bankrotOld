<?php

namespace Bankrot\SiteBundle\Controller;

use Bankrot\ParserBundle\Entity\Trader;
use Bankrot\ParserBundle\Parser\UserAgentGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DomCrawler\Crawler;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home", defaults={"page": 0})
     * @Route("/page{page}", name="home_paged", requirements={"page": "\d+"})
     * @Template()
     */
    public function indexAction($page)
    {
        $lots = $this->getDoctrine()
            ->getRepository('BankrotParserBundle:Lot')
            ->findBy([], ['createdAt' => 'DESC'], 10, 10 * $page);

        return [
            'lots' => $lots,
            'page' => $page,
        ];
    }

    /**
     * @Route("/calend", name="calend")
     * @Template()
     */
    public function calendAction()
    {
        return [];
    }

    /**
     * @Route("/test", name="test")
     * @Template()
     */
    public function testAction()
    {

        $em = $this->get('doctrine.orm.default_entity_manager');

//        $postinfo = '__ASYNCPOST=true&__EVENTARGUMENT=Page%241&__EVENTTARGET=ctl00%24cphBody%24TradePlaceList1%24gvTradePlace&__PREVIOUSPAGE=HDu5WZsPinzPm0k_Wr3XIJY9wz1qo8UufdXzUyhXDDtr_vv1OML9tcWVHXe52V6fK6KwxIzBsxM2EfiBa48vvmDLx66s4FevQKpesU6ZAWYLVjld0&__VIEWSTATE=%2FwEPDwUJNDcwMTU1MDkwD2QWAmYPZBYEZg8UKwACFCsAAw8WAh4XRW5hYmxlQWpheFNraW5SZW5kZXJpbmdoZGRkZGQCAg9kFgwCAw9kFgICBg8PFgIfAGhkZAIIDw8WAh4LTmF2aWdhdGVVcmwFFn4vU3Vic2NyaWJlckxvZ2luLmFzcHhkZAILDw8WAh8BBSRodHRwOi8vd3d3LmZlZHJlc3Vycy5ydS9EZWZhdWx0LmFzcHhkZAIXD2QWBGYPFgIeC18hSXRlbUNvdW50AgMWBmYPZBYEZg8VAQoxMC4wNy4yMDE1ZAIBDxUCAzcxM8IB0KDQsNCx0L7RgtC90LjQutC4INCyINCg0KQg0YEg0L7QutGC0Y%2FQsdGA0Y8g0YHQvNC%2B0LPRg9GCINGC0YDQtdCx0L7QstCw0YLRjCDQv9GA0LjQt9C90LDRgtGMINC40YUg0L%2FRgNC10LTQv9GA0LjRj9GC0LjRjyDQsdCw0L3QutGA0L7RgtCw0LzQuCDQsiDRgdC70YPRh9Cw0LUg0L3QtdCy0YvQv9C70LDRgtGLINC30LDRgNC%2F0LvQsNGC0YtkAgEPZBYEZg8VAQowOS4wNy4yMDE1ZAIBDxUCAzcxMqwB0J%2FQvtC70YPRh9C10L3RiyDRgdCy0L7QtNC90YvQtSDRgNC10LfRg9C70YzRgtCw0YLRiyDQv9GA0L7RhtC10LTRg9GALCDQv9GA0LjQvNC10L3Rj9Cy0YjQuNGF0YHRjyDQsiDQtNC10LvQtSDQviDQsdCw0L3QutGA0L7RgtGB0YLQstC1LCDQt9CwIDIg0LrQstCw0YDRgtCw0LsgMjAxNSDQs9C%2B0LTQsGQCAg9kFgRmDxUBCjA2LjA3LjIwMTVkAgEPFQIDNzExW9Cn0LjRgdC70L4g0LHQsNC90LrRgNC%2B0YLRgdGC0LIg0LIg0KDQvtGB0YHQuNC4INCy0YvRgNC%2B0YHQu9C%2BINC30LAg0L%2FQvtC70LPQvtC00LAg0L3QsCAxNSVkAgEPD2QPEBYBZhYBFgIeDlBhcmFtZXRlclZhbHVlBQEzFgFmZGQCGA9kFgICAQ8WAh8CAgcWDmYPZBYCZg8VAhVodHRwOi8va2FkLmFyYml0ci5ydS8w0JrQsNGA0YLQvtGC0LXQutCwINCw0YDQsdC40YLRgNCw0LbQvdGL0YUg0LTQtdC7ZAIBD2QWAmYPFQJAaHR0cDovL3d3dy5lY29ub215Lmdvdi5ydS9taW5lYy9hY3Rpdml0eS9zZWN0aW9ucy9Db3JwTWFuYWdtZW50Ly%2FQnNC40L3RjdC60L7QvdC%2B0LzRgNCw0LfQstC40YLQuNGPINCg0L7RgdGB0LjQuGQCAg9kFgJmDxUCFWh0dHA6Ly9lZ3J1bC5uYWxvZy5ydRbQldCT0KDQrtCbINCk0J3QoSDQoNCkZAIDD2QWAmYPFQItIGh0dHA6Ly90ZXN0LWJhbmtyb3QuaW50ZXJmYXgucnUvZGVmYXVsdC5hc3B4KNCi0LXRgdGC0L7QstCw0Y8g0LLQtdGA0YHQuNGPINCV0KTQoNCh0JFkAgQPZBYCZg8VAh5odHRwOi8vdGVzdC1mYWN0cy5pbnRlcmZheC5ydS8s0KLQtdGB0YLQvtCy0LDRjyDQstC10YDRgdC40Y8g0JXQpNCg0KHQlNCu0JtkAgUPZBYCZg8VAiUgIGh0dHA6Ly9mb3J1bS1mZWRyZXN1cnMuaW50ZXJmYXgucnUvMtCk0L7RgNGD0Lwg0KTQtdC00LXRgNCw0LvRjNC90YvRhSDRgNC10LXRgdGC0YDQvtCyZAIGD2QWAmYPFQIuaHR0cDovL2Jhbmtyb3QuZmVkcmVzdXJzLnJ1L0hlbHAvRkFRX0VGUlNCLnBkZjTQp9Cw0YHRgtC%2BINC30LDQtNCw0LLQsNC10LzRi9C1INCy0L7Qv9GA0L7RgdGLIChGQVEpZAIaD2QWAgIBD2QWAgIBD2QWAmYPZBYCAgEPDxYCHgdWaXNpYmxlaGQWAmYPDxYEHgRUZXh0BUHQrdGC0L7Qs9C%2BINC90LUg0LTQvtC70LbQvdC%2BINCx0YvRgtGMINC30LTQtdGB0Ywg0L3QsNC%2F0LjRgdCw0L3Qvh8EaGRkGAIFHl9fQ29udHJvbHNSZXF1aXJlUG9zdEJhY2tLZXlfXxYJBRZjdGwwMCRyYWRXaW5kb3dNYW5hZ2VyBSljdGwwMCRQcml2YXRlT2ZmaWNlMSRpYlByaXZhdGVPZmZpY2VFbnRlcgUhY3RsMDAkUHJpdmF0ZU9mZmljZTEkY2JSZW1lbWJlck1lBSBjdGwwMCRQcml2YXRlT2ZmaWNlMSRSYWRUb29sVGlwMQUfY3RsMDAkUHJpdmF0ZU9mZmljZTEkaWJ0UmVzdG9yZQUiY3RsMDAkRGVidG9yU2VhcmNoMSRpYkRlYnRvclNlYXJjaAUnY3RsMDAkY3BoQm9keSRUcmFkZVBsYWNlTGlzdDEkYnRuU2VhcmNoBShjdGwwMCRjcGhCb2R5JFRyYWRlUGxhY2VMaXN0MSRpYlNyb0NsZWFyBSpjdGwwMCRjcGhCb2R5JFRyYWRlUGxhY2VMaXN0MSRjYlRyYWRlUGxhY2UFKmN0bDAwJGNwaEJvZHkkVHJhZGVQbGFjZUxpc3QxJGd2VHJhZGVQbGFjZQ88KwAMAgICAggCBGQ%3D&ctl00%24DebtorSearch1%24inputDebtor=%D0%BF%D0%BE%D0%B8%D1%81%D0%BA&ctl00%24News1%24hfMaxSize=3&ctl00%24PrivateOffice1%24ctl00=ctl00%24cphBody%24TradePlaceList1%24upTradePlaceList%7Cctl00%24cphBody%24TradePlaceList1%24gvTradePlace&ctl00%24PrivateOffice1%24tbEmailForPassword=&ctl00%24PrivateOffice1%24tbLogin=&ctl00%24PrivateOffice1%24tbPassword=&ctl00%24cphBody%24TradePlaceList1%24hfName=&ctl00%24cphBody%24TradePlaceList1%24hfSite=&ctl00%24cphBody%24TradePlaceList1%24tbName=&ctl00%24cphBody%24TradePlaceList1%24tbSite=&ctl00_PrivateOffice1_RadToolTip1_ClientState=';
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, 'http://bankrot.fedresurs.ru/TradePlaceList.aspx');
//        curl_setopt($ch, CURLOPT_USERAGENT, UserAgentGenerator::get());
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


//        curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt"); //Из какого файла читать
//        curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt"); //В какой файл записывать


//        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, '');


//        $raw = iconv('utf8', 'cp1251', curl_exec($ch));
//        curl_close($ch);

        $filename = __DIR__ . '/../Resources/data/bankrot_trades/page4.html';
        $file = new \SplFileObject($filename);
        $raw = '';
        foreach ($file as $num => $line) {
            $raw .= $line;
        }

        $crawler = new Crawler(iconv('utf8', 'cp1251',$raw));
        $crawler->filter('#ctl00_cphBody_TradePlaceList1_gvTradePlace')
            ->filter('tr')
            ->reduce(
                function (Crawler $sets, $i) use (&$result) {
                    if(count($sets->children()) !== 3) {
                        return;
                    }
                    $sets->filter('td')
                        ->reduce(function ($set, $j) use (&$result, $i) {
                            $raw = trim($set->html());
                            switch ($j) {
                                case 1:
                                        $result[$i]['link'] = strip_tags($raw);
                                    break;
                                case 2:
                                    if (preg_match('/(.*)(<span.*$)/', $raw, $m)) {
                                        $result[$i]['name'] = $m[1];
                                    }
                                    else {
                                        $result[$i]['name'] = $raw;
                                    }
                                    break;
                            }
                        }
                        );
                }
            );
        foreach ($result as $k => $v) {
            if (!$em->getRepository('BankrotParserBundle:Trader')->findBy(
                array(
                    'name' => $v['name']
                )
            )) {
                $trader = new Trader();
                $trader->setName($v['name']);
                $trader->setUrl($v['link']);
                $em->persist($trader);
                $em->flush();
            }
        }
        return [
            'result' => $result,
            'raw' => $raw
        ];
    }

    /**
     * @Route("/page/{url}", name="page")
     * @Template()
     */
    public function pageAction($url){
        $page = $this->getDoctrine()->getRepository('BankrotSiteBundle:Page')->findOneByUrl($url);
        return array('page' => $page);
    }
}
