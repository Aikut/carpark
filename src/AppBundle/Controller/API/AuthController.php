<?php

namespace AppBundle\Controller\API;

use Application\Sonata\UserBundle\Entity\User;
use AppBundle\Entity\UserAccessToken;
use AppBundle\Exception\API\ApiException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/api")
 */
class AuthController extends Controller
{
    /**
     * @Route("/login", name="api_login")
     * @Method("POST")
     * @ApiDoc(
     *     resource=true,
     *     section="Auth",
     *     description="Login",
     *     requirements={
     *          {"name"="username", "dataType"="string", "requirement"="\s+", "description"="Username"},
     *          {"name"="password", "dataType"="string", "requirement"="\s+", "description"="Password"},
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function loginAction(Request $request)
    {
        $username = strip_tags($request->get('username'));
        $username = htmlentities($username, ENT_QUOTES, "UTF-8");
        $username = htmlspecialchars($username, ENT_QUOTES);

        $password = strip_tags($request->get('password'));
        $password = htmlentities($password, ENT_QUOTES, "UTF-8");
        $password = htmlspecialchars($password, ENT_QUOTES);


        $userRepository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:User');
        $user           = $userRepository->findOneBy(array('username' => $username));

        if (empty($user)) {
            throw new ApiException($username." User doesn't exist", 404);
        }

        $encodedPassword = $this->container->get('api.password_encoder')->encode($user, $password);

        if ($encodedPassword != $user->getPassword()) {
            throw new ApiException("Invalid user credentials", 400);
        }

        $tokenLifetime = $this->get('service_container')->getParameter('api_token_lifetime');
        if (!$tokenLifetime) {
            $tokenLifetime = UserAccessToken::DEFAULT_LIFETIME;
        }

        $dateTime        = new \DateTime('now');
        $userAccessToken = new UserAccessToken();
        $userAccessToken->setAccessToken($this->get('api.token_generator')->generate());
        $userAccessToken->setUser($user);
        $userAccessToken->setExpiredAt($dateTime->add(\DateInterval::createFromDateString($tokenLifetime.' seconds')));

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($userAccessToken);
        $em->flush();

        return new JsonResponse(
            array(
                'token' => $userAccessToken->getAccessToken(),
                'username' => $user->getUsername(),
            )
        );

    }

    /**
     * @Route("/registration", name="api_register")
     * @Method("POST")
     * @ApiDoc(
     *     resource=true,
     *     section="Auth",
     *     description="Register",
     *     requirements={
     *          {"name"="name", "dataType"="string", "requirement"="\s+", "description"="Name"},
     *          {"name"="username", "dataType"="string", "requirement"="\s+", "description"="Username"},
     *          {"name"="email", "dataType"="string", "requirement"="\s+", "description"="Email"},
     *          {"name"="plain_password", "dataType"="string", "requirement"="\s+", "description"="Plain password"},
     *          {"name"="confirm_password", "dataType"="string", "requirement"="\s+", "description"="Confirm password"},
     *     }
     * )
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function registrationAction(Request $request)
    {

        $name = strip_tags($request->get('name'));
        $name = htmlentities($name, ENT_QUOTES, "UTF-8");
        $name = htmlspecialchars($name, ENT_QUOTES);

        $phone = strip_tags($request->get('phone'));
        $phone = htmlentities($phone, ENT_QUOTES, "UTF-8");
        $phone = htmlspecialchars($phone, ENT_QUOTES);


        $phoneCode = strip_tags($request->get('phoneCode'));
        $phoneCode = htmlentities($phoneCode, ENT_QUOTES, "UTF-8");
        $phoneCode = htmlspecialchars($phoneCode, ENT_QUOTES);


        $username = $phoneCode . $phone;



        $email = strip_tags($request->get('email'));
        $email = htmlentities($email, ENT_QUOTES, "UTF-8");
        $email = htmlspecialchars($email, ENT_QUOTES);


        $phone = strip_tags($request->get('phone'));
        $phone = htmlentities($phone, ENT_QUOTES, "UTF-8");
        $phone = htmlspecialchars($phone, ENT_QUOTES);

        $firstPassword = strip_tags($request->get('plain_password'));
        $firstPassword = htmlentities($firstPassword, ENT_QUOTES, "UTF-8");
        $firstPassword = htmlspecialchars($firstPassword, ENT_QUOTES);

        $secondPassword = strip_tags($request->get('confirm_password'));
        $secondPassword = htmlentities($secondPassword, ENT_QUOTES, "UTF-8");
        $secondPassword = htmlspecialchars($secondPassword, ENT_QUOTES);

        //Check if user exists
        if (!empty($username) AND !empty($email) AND !empty($firstPassword) AND !empty($secondPassword AND $firstPassword == $secondPassword)) {
            $userRepository = $this->getDoctrine()->getRepository('ApplicationSonataUserBundle:User');
            $user           = $userRepository->findOneBy(array('username' => $username));
            $user1          = $userRepository->findOneBy(array('email' => $email));
            $em             = $this->getDoctrine()->getManager();
            if (!empty($user) OR !empty($user1)) {
                throw new ApiException("User already exist", 403);
            } elseif (empty($user) AND !empty($username)) {
                $userManipulator = $this->get('fos_user.util.user_manipulator');
                $isActive        = true;
                $isSuperAdmin    = false;
                $userManipulator->create($username, $firstPassword, $email, $isActive, $isSuperAdmin);
                $user = $em->getRepository('ApplicationSonataUserBundle:User')->findOneByUsername($username);

                /* @var $user User */
                if ($user) {
                    $user->setFirstname($name);
                    $user->setPhone($phoneCode . $phone);
                    $user->setExpired(true);
                    $em->persist($user);
                    $em->flush();
                }

            }
        }

        //Create a new user
        if (empty($user)) {
            throw new ApiException("error");
        }

        $tokenLifetime = $this->get('service_container')->getParameter('api_token_lifetime');
        if (!$tokenLifetime) {
            $tokenLifetime = UserAccessToken::DEFAULT_LIFETIME;
        }

        $dateTime        = new \DateTime('now');
        $userAccessToken = new UserAccessToken();
        $userAccessToken->setAccessToken($this->get('api.token_generator')->generate());
        $userAccessToken->setUser($user);
        $userAccessToken->setExpiredAt($dateTime->add(\DateInterval::createFromDateString($tokenLifetime.' seconds')));

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($userAccessToken);
        $em->flush();

        return new JsonResponse(
            array(
                'user' => array(
                    'token'    => $userAccessToken->getAccessToken(),
                    'username' => $user->getUsername(),
                    'email'    => $user->getEmail(),
                    'phone'    => $user->getPhone(),
                    'name'     => $user->getUsername(),
                    'whatsapp' => $user->getWhatsapp(),
                    'viber'    => $user->getViber(),
                ),
            )
        );
    }

    /** This action is created only for testing purpose */
    /**
     * @Route("/test", name="api_test")
     * @Method("GET")
     */
    public function testAction()
    {
        /** @var User $user */
        $user = $this->getUser();

        return new JsonResponse(
            array(
                'user' => $user->getEmail(),
            )
        );
    }
}
