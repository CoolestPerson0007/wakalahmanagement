<?php

namespace App\Support\Library;

/**
 * Lightweight Directory Access Protocol
 *
 * @package         LDAP
 * @author          Muhammad Hamizi Jaminan <hamizi@tab.com.my>
 * @copyright       Copyright (c) 2017, Telekom Applied Business Sdn. Bhd.
 * @license         LGPL, see included license file
 * @link            http://www.tab.com.my
 */

class ActiveDirectory
{
    /**
     * connection link
     */
    private static $link;

    /**
     * Classes which have a constructor method call this method on each newly-created object, 
     * so it is suitable for any initialization that the object may need before it is used.
     */
    public function __construct()
    {
        // force accept certificate
        putenv('LDAPTLS_REQCERT=never');

        // check ldap 
        if ( ! function_exists('ldap_connect'))
        {
            throw new \Exception('LDAP extension not installed on the server');
            return false;
        }

        // set debug level
        ldap_set_option(self::$link, LDAP_OPT_DEBUG_LEVEL, 7);
    }

    /**
     * validate credential at ldap server
     * 
     * @param  array $credentials ldap credentials
     * @return bool
     */
    public static function validate($credentials)
    {   
        if ( ! self::$link = ldap_connect('ldaps://' . config('ldap.host') . ':' . config('ldap.port')) )
        {
            throw new \Exception('Unable to connect to LDAP server');
            return false;
        }

        self::setOptions();
        $resource = @ldap_bind(self::$link, 'cn=' . $credentials['username'] . ',' . config('ldap.org'), $credentials['password']);

        return $resource;
    }

    /**
     * initiate admin login to ldap server
     * 
     * @return bool
     */
    private static function adminValidate()
    {        
        if ( ! self::$link = ldap_connect('ldaps://' . config('ldap.host') . ':' . config('ldap.port')) )
        {
            throw new \Exception('Unable to connect to LDAP server');
            return false;
        }

        self::setOptions(); 
        $resource = @ldap_bind(self::$link, 'cn=' . config('ldap.admin_user') . ',' . config('ldap.admin_org'), config('ldap.admin_pass'));

        return $resource;
    }

    /**
     * initiate login to ldap server
     * 
     * @param  string $username    ldap username
     * @return array
     */
    public static function getProfile($username)
    {   
        // ldap attribute & filter
        $attributes = ['ppempstatus', 'logindisabled', 'mail', 'pphomeno', 'mobile',
                       'ppreporttoname', 'ppsuborgunitdesc', 'pporgunitdesc', 'company', 
                       'ppmanagerlevel', 'pppostdesc', 'ppgender', 'ppnewic', 'cn', 'sn'];
        $filter = 'cn=' . $username;

        // login admin
        self::adminValidate();

        // search on ldap
        $resource = ldap_search(self::$link, config('ldap.org'), $filter, $attributes);
        $entry = ldap_get_entries(self::$link, $resource);
        $firstEntry = ldap_first_entry(self::$link, $resource);
        $attrs = ldap_get_attributes(self::$link, $firstEntry);
        
        $profile = [];
        for ($i=0; $i < $attrs['count']; $i++)
            $profile[self::mapAttribute($attrs[$i])] = $entry[0][$attrs[$i]][0];
        
        return (object) $profile;
    }

    /**
     * remap ldap attribute
     * 
     * @param  string $attr    ldap attribute
     * @return string
     */
    private static function mapAttribute($attr)
    {
        $attributes = ['sn' => 'name', 'cn' => 'staff_id', 'ppnewic' => 'nirc', 'ppgender' => 'gender',
                       'pppostdesc' => 'position', 'ppmanagerlevel' => 'level', 'company' => 'division',
                       'pporgunitdesc' => 'unit', 'ppsuborgunitdesc' => 'sub_unit', 'ppreporttoname' => 'supervisor',
                       'mobile' => 'mobile', 'pphomeno' => 'phone', 'mail' => 'email', 'logindisabled' => 'is_blocked',
                       'ppempstatus' => 'is_employee'];

        return $attributes[$attr] ? : $attr;
    }

    /**
     * setting ldap option values
     * 
     * @return void
     */
    private static function setOptions()
    {
        ldap_set_option(self::$link, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option(self::$link, LDAP_OPT_NETWORK_TIMEOUT, 15);
        ldap_set_option(self::$link, LDAP_OPT_TIMELIMIT, 15);
        ldap_set_option(self::$link, LDAP_OPT_TIMEOUT, 15);
    }
}