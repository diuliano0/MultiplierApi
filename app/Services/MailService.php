<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 17/01/2017
 * Time: 14:22
 */

namespace App\Services;


class MailService
{

    private $from;
    /**
     * @var string
     */
    private $to;

    public function __construct()
    {
        $this->from = env('MAIL_DEFAULT_SENDER',' awsprotocantins@gmail.com');
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @param string $to
     */
    public function setFrom(string $from)
    {
        $this->from = $from;
        return $this;
    }

    public function queue($to, $subject, $views, $data)
    {
        return \Mail::queue($views,compact('data'),function ($message)use ($to, $subject, $data){
            $message
                ->from($this->getFrom())
                ->to($to)
                ->subject($subject);
        });
    }

}
