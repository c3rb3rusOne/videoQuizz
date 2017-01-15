<?php
// src/BaseBundle/Service/Mailer.php
namespace BaseBundle\Service;

class Mailer
{
    protected $mailer;
    protected $templating;

    public function __construct($mailer, $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sentValidationEmail($email, $urlValidation)
    {
        print('ici');

        $message = \Swift_Message::newInstance()
            ->setSubject('subject')
            ->setFrom('cerbere53@gmail.com') // CONST
            ->setTo('e.josselin@wanadoo.fr') // $email
            ->setBody(
                $this->templating->render(
                    'Email/ConfirmationMail.html.twig',
                    array('url' => $urlValidation) // Obligatoirement dans app/Resources/views/Emails/registration.html.twig
                ),
                'text/html'
            );

        $this->mailer->send($message);

        /*$message = \Swift_Message::newInstance()
            ->setSubject('subject')
            ->setFrom('cerbere53@gmail.com') // CONST
            ->setTo('e.josselin@wanadoo.fr') // $email
            ->setBody(
                $this->renderView(
                    'Email/ConfirmationMail.html.twig',
                    array('url' => $urlValidation) // Obligatoirement dans app/Resources/views/Emails/registration.html.twig
                ),
                'text/html'
            );

        $this->get('mailer')->send($message);*/
    }
}