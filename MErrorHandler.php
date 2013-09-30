<?php
/**
 * Class file for MErrorHandler
 * @author Mark Joyner
 */

/**
 * Extends the yii CErrorHandler class to also send the error to an Airbrake
 * error logging server see 
 */
class MErrorHandler extends CErrorHandler {

    /**
     * @var string The API key given by the airbrake server
     */
    public $APIKey;

    /**
     * @var array Optional options to setup the airbrake client 
     */
    public $options;

    /**
     * First sends the exception to Airbrake and then calls the parent method
     * @param Exception $exception
     */
    protected function handleException(Exception $exception) {

        $client = $this->startClient();

        Yii::log('sending exception report to Airbrake');
        $client->notifyOnException($exception);
        
        parent::handleException($exception);
    }

    /**
     * First sends the error to Airbrake and then calls the parent method
     * @param CErrorEvent $event
     */
    protected function handleError(CErrorEvent $event) {

        $client = $this->startClient();

        $trace = debug_backtrace();
        // skip the first 3 stacks as they do not tell the error position
        if (count($trace) > 3)
            $trace = array_slice($trace, 3);

        Yii::log('sending error report to Airbrake');
        $client->notifyOnError($event->message, $trace);
        
        parent::handleError($event);
    }

    /**
     * Creates a new client based on the API key and options
     * @return \Airbrake\Client The Airbrake client
     */
    private function startClient() {

        $config = new \Airbrake\Configuration($this->APIKey, $this->options);
        return new Airbrake\Client($config);
    }

}