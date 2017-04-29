<?php namespace Rollbar\Payload;

use Rollbar\Utilities;

class Message extends ContentInterface
{
    private $body;
    private $extra;
    private $backtrace;

    public function __construct(
        $body, 
        array $extra = null, 
        $backtrace = null
    ) {
        $this->setBody($body);
        $this->setBacktrace($backtrace);
        $this->extra = $extra == null ? array() : $extra;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
    
    public function getBacktrace()
    {
        return $this->backtrace;
    }

    public function setBacktrace($backtrace)
    {
        $this->backtrace = $backtrace;
        return $this;
    }

    public function __set($key, $val)
    {
        $this->extra[$key] = $val;
    }

    public function __get($key)
    {
        return isset($this->extra[$key]) ? $this->extra[$key] : null;
    }

    public function jsonSerialize()
    {
        $toSerialize = array(
            "body" => $this->getBody(),
            "backtrace" => $this->getBacktrace()
        );
        foreach ($this->extra as $key => $value) {
            $toSerialize[$key] = $value;
        }
        return Utilities::serializeForRollbar($toSerialize, null, array_keys($this->extra));
    }
}
