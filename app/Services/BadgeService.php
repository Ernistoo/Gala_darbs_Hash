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
        $this->storyteller($user);
        $this->popular($user);
        $this->level1Unlocked($user);
        $this->level5Elite($user);
    }



    private function firstCollection(User $user): void
    {
        if ($user->collections()->count() === 1) {
            $this->awardBadge($user, 'First Collection', 'award.jpg', 'Created your first collection!', 50);
        }
    }

    private function fiveCollections(User $user): void
    {
        if ($user->collections()->count() === 5) {
            $this->awardBadge($user, 'Collector Lv.1', 'five_collections.png', 'Created 5 collections!', 100);
        }
    }

    private function firstPost(User $user): void
    {
        if ($user->posts()->count() === 1) {
            $this->awardBadge($user, 'First Post', 'first_post.png', 'Published your first post!', 50);
        }
    }

    private function fifthPost(User $user): void
    {
        if ($user->posts()->count() === 5) {
            $this->awardBadge($user, 'Influencer Lv.1', 'fifth_post.png', 'Published 5 posts!', 100);
        }
    }

    private function storyteller(User $user): void
    {
        if ($user->posts()->count() >= 10 && !$this->hasBadge($user, 'Storyteller')) {
            $this->awardBadge($user, 'Storyteller', 'storyteller.png', 'Created 10+ posts!', 150);
        }
    }



    private function popular(User $user): void
    {
        if (method_exists($user, 'mentions_received') && $user->mentions_received()->count() >= 10 && !$this->hasBadge($user, 'Popular')) {
            $this->awardBadge($user, 'Popular', 'popular.png', 'Mentioned 10+ times by others!', 200);
        }
    }


    private function level1Unlocked(User $user): void
    {
        if ($user->xp >= 100 && !$this->hasBadge($user, 'Level 1 Unlocked')) {
            $this->awardBadge($user, 'Level 1 Unlocked', 'winner.png', 'Reached Level 1 (100 XP)!', 0);
        }
    }

    private function level5Elite(User $user): void
    {
        if ($user->xp >= 1000 && !$this->hasBadge($user, 'Level 5 Elite')) {
            $this->awardBadge($user, 'Level 5 Elite', 'level5.png', 'Elite status unlocked (1000 XP)!', 0);
        }
    }


    private function awardBadge(User $user, string $name, string $image, string $description, int $xpReward = 0): void
    {
        $badge = Badge::firstOrCreate(
            ['name' => $name],
            ['image' => $image, 'description' => $description]
        );

        if (!$user->badges->contains($badge->id)) {
            $user->badges()->attach($badge->id);

            if ($xpReward > 0) {
                $user->increment('xp', $xpReward);
            }

            session()->flash('badge_earned', true);
            session()->flash('badge_image', $badge->image);
            session()->flash('badge_name', $badge->name);
            session()->flash('badge_description', $badge->description);
            session()->flash('xp_reward', $xpReward);

            $xpText = $xpReward > 0 ? " (+{$xpReward} XP)" : '';
            $user->notify(new GenericNotification("You earned a new badge: {$badge->name}{$xpText}"));
        }
    }

    private function hasBadge(User $user, string $name): bool
    {
        return $user->badges()->where('name', $name)->exists();
    }
}
