<?php

namespace App\Service\Api;

use App\Entity\User;
use App\Exception\AuthenticateException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PHPUnit\Util\Exception;

class SecurityServiceApi extends ServiceEntityRepository
{
    const JWT_SECURITY_KEY = "wBGY6vwml0x8pTLg7UBi";

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param array $array_to_encrypt
     * @return string
     */
    public function encryptArray(array $array_to_encrypt) : string
    {
        return JWT::encode($array_to_encrypt, self::JWT_SECURITY_KEY, "HS256");
    }

    /**
     * @param $token
     * @return User|null
     */
    public function apiUseValidate($token) : ?User
    {
        try {
            $decoded_obj = JWT::decode($token, new Key(self::JWT_SECURITY_KEY, 'HS256'));

            if(!is_object($decoded_obj) OR (!isset($decoded_obj->user_id)) ) {
                throw new AuthenticateException("Invalid payload");
            }

            $user = $this->getEntityManager()->getRepository(User::class)->find($decoded_obj->user_id);

            if(!($user instanceof User)) {
                throw new Exception();
            }

            return $user;
        }
        catch (\Exception $exception) {
            return null;
        }
    }
}