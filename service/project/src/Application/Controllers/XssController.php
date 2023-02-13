<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Exception;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

class XssController
{
    private Twig $twig;
    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        setcookie('TEST_VALUE', '1');
        return $this->twig->render($response, 'Xss/index.twig');
    }

    public function output(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();
        $input = $body['input'] ?? null;
        if (!$input) {
            throw new Exception('入力されていません');
        }

        return $this->twig->render(
            $response, 
            'Xss/output.twig',
            ['input' => $input]
        );
    }

    public function fix(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        // indexと同じ
        setcookie('TEST_VALUE', '2');
        return $this->twig->render($response, 'Xss/index.twig');
    }

    public function outputFix(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $body = $request->getParsedBody();
        // phpの標準関数を利用してエスケープを実行する
        // 他には利用してるテンプレートの機能を用いてエスケープするなどの方法も考えられます
        $input = $body['input'] ? htmlspecialchars($body['input']) :  null;
        if (!$input) {
            throw new Exception('入力されていません');
        }

        return $this->twig->render(
            $response, 
            'Xss/output.twig',
            ['input' => $input]
        );
    }
}