<?php namespace knowledgeValues\test\Core;

class BladeWrapper
{
    private $blade;
    private $always;

    public function __construct($views, $cache, $always = [])
    {
        $this->blade = new \Philo\Blade\Blade($views, $cache);
        $this->always = $always;
    }

    public function render($template, $data = [])
    {
        $this->always['flash'] = $this->always['app']->view()->getData('flash');
        return $this->blade->view()->make($template, array_merge($this->always, $data))->render();
    }
}