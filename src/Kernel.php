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
        $requestParams = ['chat_id' => 0, 'text' => 'TestMSG from pb-bot (cli)'];
        $method = 'sendMessage';

        if (Validation::isSAPI()) {
            //logic for sapi
            $validation = new SapiValidation();
        } else {
            $validation = new WebValidation();
            if (!$validation->isMethodAvailable()) {
                throw new \RuntimeException('Invalid request method');
            }
        }

        $validation->setConfig(
            $this->getApplication()->getBind(ConfigInterface::class)
        );

        $this->getApplication()->get('Logger')->debug('Request before validation', $requestParams);

        if (!$validation->validate($requestParams)) {
            return json_encode($validation->getValidMessage());
        }

        if (!$validation->validateMethods($method)) {
            throw new \RuntimeException('Invalid method for request (for Bot)');
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