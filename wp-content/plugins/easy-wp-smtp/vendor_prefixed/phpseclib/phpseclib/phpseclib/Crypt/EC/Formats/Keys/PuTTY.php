<?php

/**
 * PuTTY Formatted EC Key Handler
 *
 * PHP version 5
 *
 * @author    Jim Wigginton <terrafrost@php.net>
 * @copyright 2015 Jim Wigginton
 * @license   http://www.opensource.org/licenses/mit-license.html  MIT License
 * @link      http://phpseclib.sourceforge.net
 */
namespace EasyWPSMTP\Vendor\phpseclib3\Crypt\EC\Formats\Keys;

use EasyWPSMTP\Vendor\phpseclib3\Common\Functions\Strings;
use EasyWPSMTP\Vendor\phpseclib3\Crypt\Common\Formats\Keys\PuTTY as Progenitor;
use EasyWPSMTP\Vendor\phpseclib3\Crypt\EC\BaseCurves\Base as BaseCurve;
use EasyWPSMTP\Vendor\phpseclib3\Crypt\EC\BaseCurves\TwistedEdwards as TwistedEdwardsCurve;
use EasyWPSMTP\Vendor\phpseclib3\Math\BigInteger;
/**
 * PuTTY Formatted EC Key Handler
 *
 * @author  Jim Wigginton <terrafrost@php.net>
 */
abstract class PuTTY extends \EasyWPSMTP\Vendor\phpseclib3\Crypt\Common\Formats\Keys\PuTTY
{
    use Common;
    /**
     * Public Handler
     *
     * @var string
     */
    const PUBLIC_HANDLER = 'EasyWPSMTP\\Vendor\\phpseclib3\\Crypt\\EC\\Formats\\Keys\\OpenSSH';
    /**
     * Supported Key Types
     *
     * @var array
     */
    protected static $types = ['ecdsa-sha2-nistp256', 'ecdsa-sha2-nistp384', 'ecdsa-sha2-nistp521', 'ssh-ed25519'];
    /**
     * Break a public or private key down into its constituent components
     *
     * @param string $key
     * @param string $password optional
     * @return array
     */
    public static function load($key, $password = '')
    {
        $components = parent::load($key, $password);
        if (!isset($components['private'])) {
            return $components;
        }
        $private = $components['private'];
        $temp = \EasyWPSMTP\Vendor\phpseclib3\Common\Functions\Strings::base64_encode(\EasyWPSMTP\Vendor\phpseclib3\Common\Functions\Strings::packSSH2('s', $components['type']) . $components['public']);
        $components = \EasyWPSMTP\Vendor\phpseclib3\Crypt\EC\Formats\Keys\OpenSSH::load($components['type'] . ' ' . $temp . ' ' . $components['comment']);
        if ($components['curve'] instanceof \EasyWPSMTP\Vendor\phpseclib3\Crypt\EC\BaseCurves\TwistedEdwards) {
            if (\EasyWPSMTP\Vendor\phpseclib3\Common\Functions\Strings::shift($private, 4) != "\0\0\0 ") {
                throw new \RuntimeException('Length of ssh-ed25519 key should be 32');
            }
            $arr = $components['curve']->extractSecret($private);
            $components['dA'] = $arr['dA'];
            $components['secret'] = $arr['secret'];
        } else {
            list($components['dA']) = \EasyWPSMTP\Vendor\phpseclib3\Common\Functions\Strings::unpackSSH2('i', $private);
            $components['curve']->rangeCheck($components['dA']);
        }
        return $components;
    }
    /**
     * Convert a private key to the appropriate format.
     *
     * @param \phpseclib3\Math\BigInteger $privateKey
     * @param \phpseclib3\Crypt\EC\BaseCurves\Base $curve
     * @param \phpseclib3\Math\Common\FiniteField\Integer[] $publicKey
     * @param string $secret optional
     * @param string $password optional
     * @param array $options optional
     * @return string
     */
    public static function savePrivateKey(\EasyWPSMTP\Vendor\phpseclib3\Math\BigInteger $privateKey, \EasyWPSMTP\Vendor\phpseclib3\Crypt\EC\BaseCurves\Base $curve, array $publicKey, $secret = null, $password = \false, array $options = [])
    {
        self::initialize_static_variables();
        $public = \explode(' ', \EasyWPSMTP\Vendor\phpseclib3\Crypt\EC\Formats\Keys\OpenSSH::savePublicKey($curve, $publicKey));
        $name = $public[0];
        $public = \EasyWPSMTP\Vendor\phpseclib3\Common\Functions\Strings::base64_decode($public[1]);
        list(, $length) = \unpack('N', \EasyWPSMTP\Vendor\phpseclib3\Common\Functions\Strings::shift($public, 4));
        \EasyWPSMTP\Vendor\phpseclib3\Common\Functions\Strings::shift($public, $length);
        // PuTTY pads private keys with a null byte per the following:
        // https://github.com/github/putty/blob/a3d14d77f566a41fc61dfdc5c2e0e384c9e6ae8b/sshecc.c#L1926
        if (!$curve instanceof \EasyWPSMTP\Vendor\phpseclib3\Crypt\EC\BaseCurves\TwistedEdwards) {
            $private = $privateKey->toBytes();
            if (!(\strlen($privateKey->toBits()) & 7)) {
                $private = "\0{$private}";
            }
        }
        $private = $curve instanceof \EasyWPSMTP\Vendor\phpseclib3\Crypt\EC\BaseCurves\TwistedEdwards ? \EasyWPSMTP\Vendor\phpseclib3\Common\Functions\Strings::packSSH2('s', $secret) : \EasyWPSMTP\Vendor\phpseclib3\Common\Functions\Strings::packSSH2('s', $private);
        return self::wrapPrivateKey($public, $private, $name, $password, $options);
    }
    /**
     * Convert an EC public key to the appropriate format
     *
     * @param \phpseclib3\Crypt\EC\BaseCurves\Base $curve
     * @param \phpseclib3\Math\Common\FiniteField[] $publicKey
     * @return string
     */
    public static function savePublicKey(\EasyWPSMTP\Vendor\phpseclib3\Crypt\EC\BaseCurves\Base $curve, array $publicKey)
    {
        $public = \explode(' ', \EasyWPSMTP\Vendor\phpseclib3\Crypt\EC\Formats\Keys\OpenSSH::savePublicKey($curve, $publicKey));
        $type = $public[0];
        $public = \EasyWPSMTP\Vendor\phpseclib3\Common\Functions\Strings::base64_decode($public[1]);
        list(, $length) = \unpack('N', \EasyWPSMTP\Vendor\phpseclib3\Common\Functions\Strings::shift($public, 4));
        \EasyWPSMTP\Vendor\phpseclib3\Common\Functions\Strings::shift($public, $length);
        return self::wrapPublicKey($public, $type);
    }
}
