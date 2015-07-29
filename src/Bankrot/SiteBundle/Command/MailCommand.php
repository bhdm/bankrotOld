<?php
namespace Bankrot\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MailCommand extends ContainerAwareCommand
{
    protected $sendTo; # doctor # reset # 7binary@gmail.com
    protected $subject = 'Портал';
    protected $template = 'BLogBundle:Digest:digest_14_07.html.twig';

    protected function configure()
    {
        $this->setName('subscription:change');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        # снимаем ограничение времени выполнения скрипта (в safe-mode не работает)
        set_time_limit(0);

        $templating = $this->getContainer()->get('templating');

        $em           = $this->getContainer()->get('doctrine')->getManager();
        $pdo          = $em->getConnection();

        # определяем, У кого подписка до вчера
        $date = new \DateTime();
        $date = $date->format('Y-m-d').' 23:59:59';
        $users = $em->createQuery('
			SELECT u
			FROM BlogBundle:User u
			WHERE d.subscriptionEnd IS NOT NULL AND d.subscriptionEnd < '.$date.'
			')->getResult();

        # рассылка по 100 пользователям за цикл
        for ($i = 0, $c = count($users); $i < $c; $i++) {
            if ($users[$i]->getRoles()[0] == 'ROLE_SUBSCRIPTION')
            $html = $templating->render($this->template, array(
                'user'       => $users[$i],
            ));

            $email = $users[$i]['username'];
            $to    = $users[$i]['username'];

            $error = $this->send($email, $to, $html, $this->subject);

            $users->setRoles('ROLE_USER;');
            $em->flush();

            if ($i && ($i % 100) == 0) {
                sleep(60);
            }
        }
    }

    public function send($email, $to, $body, $subject, $local = false)
    {
        $mail = new \PHPMailer();

        $mail->isSMTP();
        $mail->isHTML(true);
        $mail->CharSet  = 'UTF-8';
        $mail->From     = 'noreply@evrika.ru';
        $mail->FromName = 'Портал';
        $mail->Subject  = $subject;
        $mail->Host     = '127.0.0.1';
        $mail->Body     = $body;
        $mail->addAddress($email, $to);
        $mail->addCustomHeader('Precedence', 'bulk');

        if ($local) {
            $mail->Host       = 'smtp.yandex.ru';
            $mail->From       = 'binacy@yandex.ru';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;
            $mail->SMTPAuth   = true;
            $mail->Username   = 'binacy@yandex.ru';
            $mail->Password   = 'oijoijoij';
        }

        return $mail->send() ? null : $mail->ErrorInfo;
    }
}