<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $event_id
 * @property int $dojang_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Dojang $dojang
 * @property-read \App\Models\Event $event
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Registration> $registrations
 * @property-read int|null $registrations_count
 * @method static \Database\Factories\ContingentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contingent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contingent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contingent query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contingent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contingent whereDojangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contingent whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contingent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contingent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contingent whereUpdatedAt($value)
 */
	class Contingent extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contingent> $contingents
 * @property-read int|null $contingents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Participant> $participants
 * @property-read int|null $participants_count
 * @method static \Database\Factories\DojangFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dojang newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dojang newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dojang query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dojang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dojang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dojang whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Dojang whereUpdatedAt($value)
 */
	class Dojang extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property int $gold_point
 * @property int $silver_point
 * @property int $bronze_point
 * @property bool $count_festival_medals
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contingent> $contingents
 * @property-read int|null $contingents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TournamentCategory> $tournamentCategories
 * @property-read int|null $tournament_categories_count
 * @method static \Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereBronzePoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereCountFestivalMedals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereGoldPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereSilverPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereUpdatedAt($value)
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property int $rank
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Registration> $registrations
 * @property-read int|null $registrations_count
 * @method static \Database\Factories\MedalFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medal whereRank($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Medal whereUpdatedAt($value)
 */
	class Medal extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $dojang_id
 * @property string $name
 * @property \App\Enums\ParticipantGender $gender
 * @property \Illuminate\Support\Carbon $birth_date
 * @property string|null $photo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Dojang $dojang
 * @method static \Database\Factories\ParticipantFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereDojangId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Participant whereUpdatedAt($value)
 */
	class Participant extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $category_id
 * @property int|null $participant_id
 * @property int $contingent_id
 * @property int|null $medal_id
 * @property \App\Enums\RegistrationStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TournamentCategory $category
 * @property-read \App\Models\Contingent $contingent
 * @property-read \App\Models\Medal|null $medal
 * @property-read \App\Models\Participant|null $participant
 * @method static \Database\Factories\RegistrationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereContingentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereMedalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereParticipantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Registration whereUpdatedAt($value)
 */
	class Registration extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $event_id
 * @property string $name
 * @property \App\Enums\TournamentType $type
 * @property \App\Enums\CategoryType $category_type
 * @property \App\Enums\TournamentGender $gender
 * @property \Illuminate\Support\Carbon $age_reference_date
 * @property int $min_age
 * @property int $max_age
 * @property string|null $weight_class_name
 * @property numeric|null $min_weight
 * @property numeric|null $max_weight
 * @property \App\Enums\PoomsaeType|null $poomsae_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Event $event
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Registration> $registrations
 * @property-read int|null $registrations_count
 * @method static \Database\Factories\TournamentCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereAgeReferenceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereCategoryType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereMaxAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereMaxWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereMinAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereMinWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory wherePoomsaeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TournamentCategory whereWeightClassName($value)
 */
	class TournamentCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

