<?php

namespace Responsive;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;
use Responsive\Exceptions\NoReferralFound;

/**
 * Class User
 * Eloquent\Model for table users
 *
 * @package Responsive
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    const WORK_CATEGORY_NONE = 0;
    const WORK_CATEGORY_DOOR_SUPERVISOR = 1;
    const WORK_CATEGORY_SECURITY_GUARD = 2;
    const WORK_CATEGORY_CLOSE_PROTECTION = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender',
        'admin', 'phone', 'photo', 'verified',
        'spent', 'added'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the verification record associated with the user.
     */
    public function verification()
    {
        return $this->hasOne(VerifyUser::class);
    }

    /**
     * Find user by verification token
     *
     * @param $token
     * @return object
     */
    public static function findByVerificationToken($token)
    {
        return static::leftJoin('verify_users', 'users.id', '=', 'verify_users.user_id')
                     ->select('users.*', 'verify_users.token as verification_token', 'verify_users.new_email')
                     ->where('verify_users.token', $token)
                     ->firstOrFail();
    }

    /**
     * Update and save the model instance with the verification token.
     * @return bool|object
     * @throws \Exception
     */
    public function generateToken()
    {
        // if current user has no email, throw an error
        if (empty($this->email)) {
            throw new \Exception("The given user instance has an empty or null email field");
        }

        // Update current verified to false first
        $this->update([
            'verified' => false
        ]);

        // delete token first if exists
        $this->verification()->delete();

        // Generate token and save it to database
        $this->verification()->create([
            'token' => $token = $this->token()
        ]);

        return $token;
    }

    /**
     * Verify the user
     *
     * @return void
     */
    public function processVerify()
    {
        // update verified status
        $this->update([
            'verified' => true
        ]);

        // verify new mail if user change their email
        $this->verifyNewEmail();

        // delete stored token
        $this->verification()->delete();
    }

    /**
     * set current user email to unverified
     *
     * @return void
     */
    public function setAsUnverified()
    {
        $this->update([
            'verified' => false
        ]);
    }

    /**
     * Handle change email
     *
     * @param $new_email
     * @return void
     * @internal param $change_email
     */
    public function changeEmail($new_email)
    {
        $this->verification()->update([
            'new_email' => $new_email
        ]);
    }

    /**
     * Update new email address in users and shop tables
     *
     * @return void
     */
    private function verifyNewEmail()
    {
        if ($new_email = $this->verification->new_email) {
            $this->update(['email' => $new_email]);

            \DB::update('update shop set seller_email="'.$new_email.'" where user_id = ?', [$this->id]);
        }
    }

    /**
     * Generate the verification token.
     *
     * @return string
     */
    private function token()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }



    /**
     * Get One Time Password (valid for 5 minutes).
     *
     * @return string
     */
    public function getOTP()
    {
        $now      = Carbon::now();
        $lifetime = 300; // 5 minutes
        $periods  = intdiv($now->timestamp - $now->copy()->startOfDay()->timestamp, $lifetime);
        $unique   = $now->toDateString() . $lifetime * $periods . $this->phone;
        $password = hash_hmac('sha512', $unique, config('app.key'));

        return substr(strtoupper($password), 0, 5);
    }

    /**
     * Get array of users that registered by your link
     *
     * @return array
     */
    public function getReferrals() {
        if ($this->id) {
            $referrals = Referral::where('to', $this->id);
            $uReferrals = [];
            foreach ($referrals->get() as $referral) {
                $uReferrals [] = User::where('id', $referral->who)->first();
            }

            return $uReferrals;
        }
        throw new NoReferralFound('No referral found');
    }

    /**
     * Get referral points balance
     *
     * @return int
     */
    public function getBalance() {
        $balance = 10 * count($this->getReferrals());
        $balance -= $this->spent;
        $balance += $this->added;

        return $balance;
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }

    public function nationality()
    {
        return $this->belongsTo(Country::class, 'nation_id');
    }

    public static function getWorkCategories() {
        return [
            User::WORK_CATEGORY_NONE => null,
            User::WORK_CATEGORY_DOOR_SUPERVISOR => 'Door Supervisor',
            User::WORK_CATEGORY_SECURITY_GUARD => 'Securoty Guard',
            User::WORK_CATEGORY_CLOSE_PROTECTION => 'Close Protection'
        ];
    }
}
