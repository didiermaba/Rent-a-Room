<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start_date')
            ->add('end_date')
            ->add('status')
            ->add('room', EntityType::class, [
                'class' => Room::class,
'choice_label' => 'name',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
'choice_label' => 'name',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Envoyer'
            ])
            // ->addEventListener(FormEvents::PRE_SUBMIT, $this->autoSlug(...))
            // ->addEventListener(FormEvents::POST_SUBMIT, $this->attach(...))
        ;
    }

    // public function autoSlug(PreSubmitEvent $event): void
    // {
    //     $data = $event->getdata();
    //     if (empty($data['slug'])) {
    //         $slugger = new AsciiSlugger();
    //         $data['slug'] = strtolower($slugger->slug($data('title')));
    //         $event->setData($data);
    //     }
    //     }
    // public function attach(PostSubmitEvent $event): void
    // {
    //     $data = $event->getdata();
    //     if (!($data instanceof reservation)) {
    //         return;
    //     }

    //     $data->setstatus(new \Int());
    //     if(!$data->getId()) {
    //         $data->setStatus(new \Int());
    //     }
    // }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
