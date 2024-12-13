<?php 

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class User extends Authenticatable
{
    //use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    use HasApiTokens, HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dial_code',
        'phone',
        'phone_verified',
        'email_verified_at',
        'role_id',
        'user_phone_otp',
        'user_device_token',
        'user_device_type',
        'user_access_token',
        'firebase_user_key',
        'trade_licence_number',
        'trade_licence_doc',
        'status',
        'login_type',
        'default_iso_code'
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    const MALE = 1;
    const FEMALE = 2;
    const BOTH = 3;

    const SINGLE = 1;
    const MARRIED = 2;
    const DIVORCED = 3;
    const WIDOWED = 4;

    const GENDER =[
        self::MALE => 'Male',
        self::FEMALE => 'Female',
    ];

    const INTERESTED_IN =[
        self::MALE => 'Male',
        self::FEMALE => 'Female',
        self::BOTH => 'Both',
    ];

    const MARITAL_STATUS =[
        self::SINGLE => 'Single',
        self::MARRIED => 'Married',
        self::DIVORCED => 'Divorced',
        self::WIDOWED => 'Widowed',
    ];

    public function getGender(){
        if(is_null($this->gender)){
            return 'Not Specified';
        }
        return self::GENDER[$this->gender];
    }

    public function getInterestedIn(){
        if(is_null($this->intrest_gender)){
            return 'Not Specified';
        }
        return self::INTERESTED_IN[$this->intrest_gender] ?? '';
    }
    public function getMaritalStatus(){
        if(is_null($this->marital_status)){
            return 'Not Specified';
        }
        return self::MARITAL_STATUS[$this->marital_status];
    }

    function nationalCountry(){
        return $this->belongsTo(Country::class,'nationality','country_id');
    }

    //public $appends = ['processed_user_image'];

    public function getProfileImageAttribute($profile_image){
        return get_uploaded_image_url($profile_image,'user_image_upload_dir','avatar.png');
    }
    public function getTradeLicenceDocAttribute($license){
        if($license !=null)
        return get_uploaded_image_url($license,'user_image_upload_dir','avatar.png');
    }

    public function CustomerType(){
        return $this->hasMany(CustomerType::class);
    }

    public function driver_detail(){
        return $this->hasOne(DriverDetail::class);
    }

    public function driver(){
        return $this->hasMany(Booking::class,'driver_id','id');
    }

    public function customer(){
        return $this->hasMany(Booking::class,'sender_id','id');
    }

    public function booking_qoutes(){
        return $this->hasMany(BookingQoute::class,'driver_id','id');
    }

    public function accepted_qoutes(){
        return $this->hasMany(AcceptedQoute::class,'driver_id','id');
    }

    public function company(){
        return $this->hasOne(Company::class,'user_id','id');
    }

    public function blacklist(){
        return $this->hasOne(Blacklist::class,'user_id','id');
    }

    public function wallet(){
        return $this->hasOne(Wallet::class,'user_id','id');
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function booking_truck_alot(){
        return $this->hasMany(BookingTruckAlot::class);
    }
    
    public function addresses(){
        return $this->hasMany(Address::class);
    }

    public static function inserDriverData($data)
    {
        $email = extractFirstEmail($data[4]) ?? null;

        if (empty($email)) {
            // $faker = FakerFactory::create();
            // $email = $faker->safeEmail;
        }

        if (!$email) {
            return null;
        }
        $user = User::where('email', $email)->first();
        $driver_details = '';
        if ($user) {
            

        }else{
            $user = new User();
            $user->name = removeExtraSpaces($data[3]) ?? 'N/A';
            $user->dial_code = removeExtraSpaces($data[5]);
            $user->phone = removeExtraSpaces($data[6]);
            $user->email = $email;
            $user->password = bcrypt('Hello@1985');
            $user->role_id = 2;
            $user->phone_verified = 1;
             $user->email_verified_at = Carbon::now();
            $user->status = removeExtraSpaces($data[7]) ?? 'inactive';

            $user->country =removeExtraSpaces($data[14]);
            $user->city = removeExtraSpaces($data[15]);
            $user->save();

            $driver_details = DriverDetail::where('user_id',$user->id)->first();
            if(!$driver_details){
                $driver_details = new DriverDetail();
            // }
                $driver_details->user_id = $user->id;
                $driver_details->is_company = "no";
                $driver_details->truck_type_id = '';
                $driver_details->total_rides = 0;
                if(removeExtraSpaces($data[0]) == 'Company'){
                    $driver_details->is_company = "yes";
                    $company = User::where('status','active')->where('role_id',4)->where('name',removeExtraSpaces($data[1]))->first();
                    $driver_details->company_id = $company->id ?? 0;
                }
                $TruckType = TruckType::where('truck_type',removeExtraSpaces($data[2]))->first();
                $driver_details->truck_type_id = $TruckType->id ?? 0;
                $driver_details->mulkia_number = removeExtraSpaces($data[8]);
                $driver_details->driving_license = '';
                $driver_details->mulkia = '';

                $country = \DB::table('countries')->where('country_status',1)->where('deleted_at',null)->where('country_name',removeExtraSpaces($data[10]))->first();

                $driver_details->driving_license_number = removeExtraSpaces($data[10]);
                $UNIX_DATE = (removeExtraSpaces($data[11]) - 25569) * 86400;
                $driver_details->driving_license_expiry = removeExtraSpaces($data[11]) ? date('Y-m-d',($UNIX_DATE )) : '';//"2023-11-30",
                $driver_details->vehicle_plate_number = removeExtraSpaces($data[12]);

                $city = \DB::table('cities')->where('city_status',1)->where('city_name',removeExtraSpaces($data[13]))->first();

                $driver_details->vehicle_plate_place = $city->id;//removeExtraSpaces($data[10]);
                $driver_details->driving_license_issued_by = $city->id;
                $driver_details->save();
                // dd($driver_details);
            }
        }
        return $user;
    }

    public function additionalPhone(){
        return $this->hasMany(UserAdditionalPhone::class,'user_id','id');
    }
}

