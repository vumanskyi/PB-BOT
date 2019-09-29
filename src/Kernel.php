<?php
declare(strict_types=1);

namespace PB;

use PB\Config\ConfigInterface;
use PB\Contracts\Application;
use PB\Contracts\Kernel as BaseKernel;
use PB\Library\Requests\RequestInterface;
use PB\Library\Responses\ResponseInterface;
use PB\Validation\SapiValidation;
use PB\Validation\Validation;
use PB\Validation\WebValidation;

class Kernel implements BaseKernel
{

    /**
     * @var Application
     */
    private $app;

    /**
     * @var Validation
     */
    private $validation;


    /**
     * Kernel constructor.
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->app = $application;
    }

    /**
     * Get service provider
     *
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->app;
    }

    /**
     * @return Validation
     */
    public function getValidation(): Validation
    {
        return $this->validation;
    }

    /**
     * @param Validation $validation
     */
    public function setValidation(Validation $validation): void
    {
        $this->validation = $validation;
    }

    /**
     * Entry point of application
     * Script run here
     */
    public function execution()
    {
        if (Validation::isSAPI()) {
            //logic for sapi
            $validation = new SapiValidation();
            $params = getopt('m:c:t:');
            $method = $params['m'] ?? '';
            $requestParams = [
                'chat_id' => $params['c'] ?? '',
                'text'    => $params['t'] ?? '',
            ];
        } else {
            $validation = new WebValidation();

            $method = $_REQUEST['method'] ?? '';
            $requestParams = [
                'chat_id' => $_REQUEST['chat_id'] ?? '',
                'text'    => $_REQUEST['text'] ?? '',
            ];
        }

        $validation->setConfig(
            $this->getApplication()->getBind(ConfigInterface::class)
        );

        $this->getApplication()->get('Logger')->debug('Request before validation', $requestParams);
        //TODO - get data from cli and web
        if (!$validation->validate($requestParams)) {
            //TODO add response solution
            return json_encode($validation->getValidMessage());
        }

        if (!$validation->validateMethods($method)) {
            //
        }

        /** @var RequestInterface $request*/
        $request = $this->getApplication()->getBind(RequestInterface::class);

        /** @var ResponseInterface $response */
        $response = $request->get($this->getBotLink() . '/' . $method, $requestParams);

        return $response->render();
    }

    /**
     * Which environment do you use in you application ?
     * There ara only the next options: test, dev, prod
     */
    public function getDevEnvironment()
    {
       return getenv('APP_ENV');
    }

    /**
     * System link for working with bot
     * @return string
     */
    protected function getBotLink(): string
    {
        return getenv('BOT_URL') . getenv('TOKEN');
    }
}