<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Endroid\QrCode\Builder\BuilderInterface;


class SecurityController extends AbstractController
{
    
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'], options: ['converter' => true])]
   public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager): Response
{
    $user = new User();

    $form = $this->createForm(UserType::class, $user);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
       

        $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

            // Set their role
            $user->setRoles(['ROLE_USER']);

        $entityManager->persist($user);
        $entityManager->flush();

       

        return $this->redirectToRoute('app_login');
    }

   

    return $this->render('security/register.html.twig', [
        'form' => $form->createView(), // Assurez-vous de passer la variable form au rendu
    ]);
}

    

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
   public function login(Request $request, AuthenticationUtils $authenticationUtils,SessionInterface $session): Response
{
    // Si l'utilisateur est déjà connecté, redirigez-le vers la page d'accueil ou une autre page appropriée
    //if ($this->getUser()) {
//$session->getFlashBag()->add('success', 'Connexion réussie !');
      //  return $this->redirectToRoute('app_index'); // Remplacez 'home' par la route appropriée
   // }
    $email = $request->request->get('_email');
    $password = $request->request->get('_password');
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastEmail = $authenticationUtils->getLastUsername();
    dump($email,$password );
    
    return $this->render('security/login.html.twig', [
        'last_email' => $lastEmail,
        'error' => $error,
        'page' => 'login',
        'showRegisterForm' => true,
    ]);
}

  
    /**
     * @Route("/forgot", name="forgot")
     */
    #[Route('/forgot', name: 'forgot')]
    public function forgotPassword(Request $request, UserRepository $userRepository,Swift_Mailer $mailer, TokenGeneratorInterface  $tokenGenerator)
    {


        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $donnees = $form->getData();//


            $user = $userRepository->findOneBy(['email'=>$donnees]);
            if(!$user) {
                $this->addFlash('danger','cette adresse n\'existe pas');
                return $this->redirectToRoute("forgot");

            }
            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $entityManger = $this->getDoctrine()->getManager();
                $entityManger->persist($user);
                $entityManger->flush();




            }catch(\Exception $exception) {
                $this->addFlash('warning','une erreur est survenue :'.$exception->getMessage());
                return $this->redirectToRoute("app_login");


            }

            $url = $this->generateUrl('app_reset_password',array('token'=>$token),UrlGeneratorInterface::ABSOLUTE_URL);

            //BUNDLE MAILER
            $message = (new Swift_Message('Mot de password oublié'))
                ->setFrom('aziz.abidi@esprit.tn')
                ->setTo($user->getEmail())
                ->setBody("<p> Bonjour</p> une demande de réinitialisation de mot de passe a été effectuée. Veuillez cliquer sur le lien suivant :".$url,
                "text/html");

            //send mail
            $mailer->send($message);
            $this->addFlash('message','E-mail  de réinitialisation du mp envoyé :');
        //    return $this->redirectToRoute("app_login");



        }

        return $this->render("security/forgotPassword.html.twig",['form'=>$form->createView()]);
    }
    

    /**
     * @Route("/resetpassword/{token}", name="app_reset_password")
     */
    #[Route('/resetpassword/{token}', name: 'app_reset_password')]
    public function resetpassword(Request $request,string $token, UserPasswordEncoderInterface  $passwordEncoder)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token'=>$token]);

        if($user == null ) {
            $this->addFlash('danger','TOKEN INCONNU');
            return $this->redirectToRoute("app_login");

        }

        if($request->isMethod('POST')) {
            $user->setResetToken(null);

            $user->setPassword($passwordEncoder->encodePassword($user,$request->request->get('password')));
            $entityManger = $this->getDoctrine()->getManager();
            $entityManger->persist($user);
            $entityManger->flush();

            $this->addFlash('message','Mot de passe mis à jour :');
            return $this->redirectToRoute("app_login");

        }
        else {
            return $this->render("security/resetPassword.html.twig",['token'=>$token]);

        }
    }


   

}