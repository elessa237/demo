<?php

namespace App\EventSubscriber;


use App\Entity\Commentaire;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

class adminSubscriber  implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setDate']
        ];
    }
    
    public function setDate(BeforeEntityPersistedEvent $event)
    {
        $entity  = $event->getEntityInstance();

        if ($entity instanceof Commentaire) {
            
            if (!$entity->getCreatedAt()) {
                $entity->setCreatedAt(new \DateTime('now'));
            }
        }

        return;

    }
}
