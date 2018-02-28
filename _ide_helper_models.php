<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Batch
 *
 * @property-read mixed $chemicals
 * @property-read mixed $intro
 */
	class Batch extends \Eloquent {}
}

namespace App{
/**
 * App\CommonChemical
 *
 */
	class CommonChemical extends \Eloquent {}
}

namespace App{
/**
 * App\CommonDevice
 *
 */
	class CommonDevice extends \Eloquent {}
}

namespace App{
/**
 * App\HazardousChemical
 *
 * @property-read mixed $hazardous_type_name
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\HazardousChemical onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\HazardousChemical withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\HazardousChemical withoutTrashed()
 */
	class HazardousChemical extends \Eloquent {}
}

namespace App{
/**
 * App\HazardousChemicalCart
 *
 */
	class HazardousChemicalCart extends \Eloquent {}
}

namespace App{
/**
 * App\HazardousChemicalOrder
 *
 * @property-read mixed $intro
 */
	class HazardousChemicalOrder extends \Eloquent {}
}

namespace App{
/**
 * App\HazardousChemicalOrderItem
 *
 */
	class HazardousChemicalOrderItem extends \Eloquent {}
}

namespace App{
/**
 * App\HazardousChemicalType
 *
 */
	class HazardousChemicalType extends \Eloquent {}
}

namespace App{
/**
 * App\RadioactiveElement
 *
 */
	class RadioactiveElement extends \Eloquent {}
}

namespace App{
/**
 * App\SafePlaceModel
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\SafePlaceModel onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\SafePlaceModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SafePlaceModel withoutTrashed()
 */
	class SafePlaceModel extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\ValuableDevice
 *
 */
	class ValuableDevice extends \Eloquent {}
}

