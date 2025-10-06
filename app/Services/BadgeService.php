<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Notifications\GenericNotification;

class BadgeService
{
    public function checkAndAssign(User $user): void
    {
        $this->firstCollection($user);
        $this->fiveCollections($user);
        $this->firstPost($user);
        $this->fifthPost($user);
    }

    private function firstCollection(User $user): void
    {
        if ($user->collections()->count() === 1) {
            $this->awardBadge($user, 'First Collection', 'award.jpg', 'Created your first collection!');
        }
    }

    private function fiveCollections(User $user): void
    {
        if ($user->collections()->count() === 5) {
            $this->awardBadge($user, 'Collector Lv.1', 'five_collections.png', 'Created 5 collections!');
        }
    }

    private function firstPost(User $user): void
    {
        if ($user->posts()->count() === 1) {
            $this->awardBadge($user, 'First Post', 'first_post.png', 'Published your first post!');
        }
    }

    private function fifthPost(User $user): void
    {
        if ($user->posts()->count() === 5) {
            $this->awardBadge($user, 'Influencer Lv.1', 'fifth_post.png', 'Published 5 posts!');
        }
    }

    private function awardBadge(User $user, string $name, string $image, string $description): void
    {
        $badge = Badge::firstOrCreate(
            ['name' => $name],
            ['image' => $image, 'description' => $description]
        );

        if (!$user->badges->contains($badge->id)) {
            $user->badges()->attach($badge->id);

            session()->flash('badge_earned', true);
            session()->flash('badge_image', $badge->image);
            session()->flash('badge_name', $badge->name);
            session()->flash('badge_description', $badge->description);

            $user->notify(new GenericNotification("You earned a new badge: {$badge->name}"));
        }
    }
}
