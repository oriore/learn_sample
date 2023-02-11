<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Domain\Mysql\Form\Input;
use Exception;
use Illuminate\Database\Capsule\Manager;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;

class MysqlController
{
    private Twig $twig;
    private Manager $capsule;
    public function __construct(Twig $twig, Manager $capsule)
	{
        $this->twig = $twig;
        $this->capsule = $capsule;
	}

    public function index(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->twig->render(
            $response, 
            'Mysql/index.twig',
            ['form_input' => null]
        );
    }

    public function injection(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $input = $request->getParsedBody();
        $name = $input['name'] ?? null;
        if (!$name) {
            throw new Exception('名前が入力されていません');
        }

        $form_input = new Input($name);
        $user_table = $this->capsule->table('user');
        // query dubug: $this->capsule->connection()->enableQueryLog();
        $users = $user_table->whereRaw('name Like \'%' . $form_input->getName() . '%\'')->get();
        // query dubug: var_dump($this->capsule->connection()->getQueryLog());
        return $this->twig->render(
            $response, 
            'Mysql/index.twig',
            [
                'form_input' => $form_input,
                'users' => $users
            ]
        );
    }

    public function fix(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->twig->render(
            $response, 
            'Mysql/index.twig',
            ['form_input' => null]
        );
    }

    public function injectionFix(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $input = $request->getParsedBody();
        $name = $input['name'] ?? null;
        if (!$name) {
            throw new Exception('名前が入力されていません');
        }

        $form_input = new Input($name);

        // before 
        // test' OR TRUE OR name LIKE 'a
        // $users = $user_table->whereRaw('name Like \'%' . $form_input->getName() . '%\'')->get();

        // using placeholder
        $user_table_query = $this->capsule
            ->table('user')
            ->where('name', 'Like', '%' . $form_input->getName() . '%');

        // other example
        // $user_table_query = $this->capsule->table('user')->whereRaw(
        //     "name LIKE CONCAT('%', ?, '%')",
        //     [$form_input->getName()]
        // );

        // query dubug: $this->capsule->connection()->enableQueryLog();
        $users = $user_table_query->get();
        // query dubug: var_dump($this->capsule->connection()->getQueryLog());
        return $this->twig->render(
            $response, 
            'Mysql/index.twig',
            [
                'form_input' => $form_input,
                'users' => $users
            ]
        );
    }
}