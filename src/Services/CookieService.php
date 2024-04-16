<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CookieService
{
    public function setUserCookie(Response $response, string $name, string $value): Response
    {
        $cookie = Cookie::create($name, $value);
        $response->headers->setCookie($cookie);
        return $response;
    }

    public function getUserFromCookie(Request $request, string $name)
    {
        return $request->cookies->get($name);
    }

    public function removeUserCookie(Response $response, string $name): Response
    {
        $response->headers->setCookie(Cookie::create($name, null));
        return $response;
    }
}
