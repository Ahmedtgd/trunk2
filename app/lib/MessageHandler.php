<?php
namespace App\lib;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Support\Facades\Config;

class MessageHandler
{
    /*
     * Improvement
     * you can also flash message in these function instead of in views
     * */
    public function success($key, $style = null, MessageBag $systemErrors = null, $xBtn = false, $autoHide = false)
    {

        $message = '<div class="alert alert-success">';
        if ($xBtn)
            $message .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';

        $message .= '<strong>' . Config::get('messages.success.' . $key . '.title') . '</strong>';
        $message .= Config::get('messages.success.' . $key . '.message');

        $message .= $this->getListFromSystemErrorArray($systemErrors);

        $message .= ' </div>';

        if ($autoHide)
            $message .= '<script>
                            window.setTimeout(function() {
                            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove();
                            });
                            }, 5000);
                         </script>';

        return $message;
    }

    public function error($key, $style = null, MessageBag $systemErrors = null, $customErrors = null, $xBtn = false, $autoHide = false)
    {

        $message = '<div class="alert alert-danger">';

        if ($xBtn)
            $message .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';

        $message .= '<strong>' . Config::get('messages.error.' . $key . '.title') . '</strong>';

        $message .= Config::get('messages.error.' . $key . '.message');

        $message .= $this->getListFromSystemErrorArray($systemErrors);

        $message .= $this->getListFromCustomErrorArray($customErrors);

        $message .= ' </div>';

        if ($autoHide)
            $message .= '<script>
                            window.setTimeout(function() {
                            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove();
                            });
                            }, 2000);
                         </script>';

        return $message;
    }


    public function warning($key, $style = null, MessageBag $systemErrors = null, $customErrors = null, $xBtn = false, $autoHide = false)
    {

        $message = '<div class="alert alert-warning">';

        if ($xBtn)
            $message .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';

        $message .= '<strong>' . Config::get('messages.warning.' . $key . '.title') . '</strong>';

        $message .= Config::get('messages.warning.' . $key . '.message');

        $message .= $this->getListFromSystemErrorArray($systemErrors);

        $message .= $this->getListFromCustomErrorArray($customErrors);

        $message .= ' </div>';

        if ($autoHide)
            $message .= '<script>
                            window.setTimeout(function() {
                            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove();
                            });
                            }, 2000);
                         </script>';

        return $message;
    }

    public function info($key, $style = null, MessageBag $systemErrors = null, $customErrors = null, $xBtn = false, $autoHide = false)
    {

        $message = '<div class="alert alert-info">';

        if ($xBtn)
            $message .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';

        $message .= '<strong>' . Config::get('messages.warning.' . $key . '.title') . '</strong>';

        $message .= Config::get('messages.info.' . $key . '.message');

        $message .= $this->getListFromSystemErrorArray($systemErrors);

        $message .= $this->getListFromCustomErrorArray($customErrors);

        $message .= ' </div>';

        if ($autoHide)
            $message .= '<script>
                            window.setTimeout(function() {
                            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove();
                            });
                            }, 2000);
                         </script>';

        return $message;
    }

    private function getListFromCustomErrorArray($customErrors = null)
    {
        $list = '';

        if ($customErrors) {
            foreach ($customErrors as $key => $value) {
                $list .= '<li>' . $value . '</li>';
            }
        }
        return $list;
    }

    private function getListFromSystemErrorArray(MessageBag $systemErrors = null)
    {
        $list = '';

        if ($systemErrors) {
            foreach ($systemErrors->all() as $key => $value) {
                $list .= '<li>' . $value . '</li>';
            }
        }
        return $list;
    }
}