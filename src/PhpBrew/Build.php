<?php
namespace PhpBrew;



/**
 * A build object contains version information, 
 * variant configuration, paths and an build identifier (BuildId)
 */
class Build
{
    const ENV_PRODUCTION = 0;
    const ENV_DEVELOPMENT = 1;

    public $version;

    public $variants = array();

    public $phpEnvironment = self::ENV_DEVELOPMENT;

    public function __construct()
    {

    }

    public function setVersion($version)
    {
        $this->version = $version;
    }


    public function getVersion()
    {
        return $this->version;
    }

    public function compareVersion($version)
    {
        return version_compare($this->version,$version);
    }

    public function addVariant($name, $value = null)
    {
        $this->variants[$name] = $value ?: true;
    }

    public function setVariants($variants)
    {
        $this->variants = $variants;
    }

    public function removeVariant($variantName)
    {
        unset($this->variants[$variantName]);
    }


    public function getVariants()
    {
        return $this->variants;
    }


    /**
     * Returns a build identifier.
     */
    public function getIdentifier()
    {
        $names = array('php');

        $names[] = $this->version;

        if($this->variants) {
            foreach($this->variants as $n => $v ) {
                $str = $n . '_' . $v;
                $str = preg_replace( '#\W+#', '_', $str );
                $names[] = $str;
            }
        }

        if($this->phpEnvironment === self::ENV_PRODUCTION ) {
            $names[] = 'prod';
        } elseif($this->phpEnvironment === self::ENV_DEVELOPMENT ) {
            $names[] = 'dev';
        }
        return join('-', $names);
    }

}


