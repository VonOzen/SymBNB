<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Booking;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_GB');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser->setFirstName('Simon')
                  ->setLastName('Escure')
                  ->setEmail('hello@simonescure.fr')
                  ->setHash($this->encoder->encodePassword($adminUser, 'password'))
                  ->setAvatar('https://avatars.io/twitter/HuguesOFraises')
                  ->setIntroduction($faker->sentence())
                  ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>')
                  ->addUserRole($adminRole);

        $manager->persist($adminUser);

        // Adding fake users
        $users = [];
        $genres = ['male', 'female'];
        for($i = 1; $i <= 10; $i++) {
            $user = new User();

            $genre = $faker->randomElement($genres);

            $avatar = "https://randomuser.me/api/portraits/";
            $avatarId = $faker->numberBetween(1, 99) . ".jpg";

            $avatar = $avatar . ($genre == 'male' ? 'men/' : 'women/') . $avatarId;

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstname($genre))
                 ->setLastName($faker->lastname)
                 ->setIntroduction($faker->sentence)
                 ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
                 ->setHash($hash)
                 ->setEmail($faker->email)
                 ->setAvatar($avatar);
            
            $manager->persist($user);
            $users[] = $user;
        }

        // Adding ads
        for($i = 1; $i <= 30; $i++) {
            $ad = new Ad();

            $title = $faker->sentence(4);
            $coverImage = $faker->imageUrl(800, 350);
            $introduction = $faker->paragraph(2);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';

            $user = $users[mt_rand(0, count($users) - 1)];

    
            $ad->setTitle($title)
               ->setCoverImage($coverImage)
               ->setIntroduction($introduction)
               ->setContent($content)
               ->setPrice(mt_rand(40, 200))
               ->setRooms(mt_rand(1, 6))
               ->setAuthor($user);
            
            for($j = 1; $j <= mt_rand(2, 5); $j++) {
                $image = new Image();

                $image->setUrl($faker->imageUrl())
                      ->setCaption($faker->sentence())
                      ->setAd($ad);
                
                $manager->persist($image);
            }

            // Adding fake Bookings
            for($j = 1; $j <= mt_rand(0, 10); $j++) {
                $booking = New Booking();

                $createdAt = $faker->dateTimeBetween('-6 months');
                $startDate = $faker->dateTimeBetween('-3 months');
                $duration  = mt_rand(2, 10);
                $endDate   = (clone $startDate)->modify("+$duration days"); #if not clone, startDate will be altered
                $amount    = $ad->getPrice() * $duration;
                $booker    = $users[mt_rand(0, count($users) - 1)];
                $comment   = $faker->paragraph();

                $booking->setBooker($booker)
                        ->setAd($ad)
                        ->setStartDate($startDate)
                        ->setEndDate($endDate)
                        ->setCreatedAt($createdAt)
                        ->setAmount($amount)
                        ->setComment($comment);
                
                $manager->persist($booking);

                //Adding fake comments
                if(mt_rand(0, 1)) {
                    $comment = new Comment();

                    $comment->setContent($faker->paragraph())
                            ->setRating(mt_rand(1, 5))
                            ->setAuthor($booker)
                            ->setAd($ad);
                    
                    $manager->persist($comment);
                }
            }
    
            $manager->persist($ad);
        }

        $manager->flush();
    }
}
