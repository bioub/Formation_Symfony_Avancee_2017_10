<?php

namespace Bioub\Bootstrap4Bundle\Twig;


use Symfony\Component\HttpFoundation\Session\Session;

class FlashAlertExtension extends \Twig_Extension
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * FlashAlertExtension constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }


    public function getFunctions()
    {
        return [
          new \Twig_SimpleFunction('flashAlert', [$this, 'flashAlert'], [
              'is_safe' => ['html' => true]
          ])
        ];
    }


    public function flashAlert($type) {
        $html = '';

        foreach ($this->session->getFlashBag()->get($type) as $msg) {
            $html .= <<<HTML
<div class="container mt-3">
    <div class="alert alert-$type alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        $msg
    </div>
</div>
HTML;
        }

        return $html;
    }
}
