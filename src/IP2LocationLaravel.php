<?php

namespace Ip2location\IP2LocationLaravel;

class IP2LocationLaravel
{
    private $db;
    private $ws;
    
    private function load($mode)
    {
        if ($mode == 'bin')
        {
            $this->db = new \IP2Location\Database($this->getDatabasePath(), \IP2Location\Database::FILE_IO);
        } else if ($mode == 'ws')
        {
            $apikey = \Config::get('site_vars.IP2LocationAPIKey');
            $package = (null !== \Config::get('site_vars.IP2LocationPackage')) ? \Config::get('site_vars.IP2LocationPackage') : 'WS1';
            $ssl = (null !== \Config::get('site_vars.IP2LocationUsessl')) ? \Config::get('site_vars.IP2LocationUsessl') : false;
            $this->ws = new \IP2Location\WebService($apikey, $package, $ssl);
        }
    }

    private function getDatabasePath()
    {
        return config('ip2locationlaravel.ip2location.local.path');
    }

    public function get($ip, $mode = 'bin')
    {
        $this->load($mode);
        if ($mode == 'bin')
        {
            $records = $this->db->lookup($ip, \IP2Location\Database::ALL);
        } else if ($mode == 'ws')
        {
            $addons = (null !== \Config::get('site_vars.IP2LocationAddons')) ? \Config::get('site_vars.IP2LocationAddons') : [];
            $language = (null !== \Config::get('site_vars.IP2LocationLanguage')) ? \Config::get('site_vars.IP2LocationLanguage') : 'en';
            $records = $this->ws->lookup($ip, $addons, $language);
        }
        
        return $records;
    }

    public function isIpv4($ip)
    {
        $ipTools = new \IP2Location\IpTools();
        return $ipTools->isIpv4($ip);
    }

    public function isIpv6($ip)
    {
        $ipTools = new \IP2Location\IpTools();
        return $ipTools->isIpv6($ip);
    }

    public function ipv4ToDecimal($ip)
    {
        $ipTools = new \IP2Location\IpTools();
        return $ipTools->ipv4ToDecimal($ip);
    }

    public function ipv6ToDecimal($ip)
    {
        $ipTools = new \IP2Location\IpTools();
        return $ipTools->ipv6ToDecimal($ip);
    }

    public function decimalToIpv4($num)
    {
        $ipTools = new \IP2Location\IpTools();
        return $ipTools->decimalToIpv4($num);
    }

    public function decimalToIpv6($num)
    {
        $ipTools = new \IP2Location\IpTools();
        return $ipTools->decimalToIpv6($num);
    }

    public function ipv4ToCidr($ipFrom, $ipTo)
    {
        $ipTools = new \IP2Location\IpTools();
        return $ipTools->ipv4ToCidr($ipFrom, $ipTo);
    }

    public function cidrToIpv4($cidr)
    {
        $ipTools = new \IP2Location\IpTools();
        return $ipTools->cidrToIpv4($cidr);
    }

    public function ipv6ToCidr($ipFrom, $ipTo)
    {
        $ipTools = new \IP2Location\IpTools();
        return $ipTools->ipv6ToCidr($ipFrom, $ipTo);
    }

    public function cidrToIpv6($cidr)
    {
        $ipTools = new \IP2Location\IpTools();
        return $ipTools->cidrToIpv6($cidr);
    }

    public function compressIpv6($ipv6)
    {
        $ipTools = new \IP2Location\IpTools();
        return $ipTools->compressIpv6($ipv6);
    }

    public function expandIpv6($ipv6)
    {
        $ipTools = new \IP2Location\IpTools();
        return $ipTools->expandIpv6($ipv6);
    }
}
