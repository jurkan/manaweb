<?php
/*
 *  The Mana Server Account Manager
 *  Copyright 2008 The Mana Server Development Team
 *
 *  This file is part of The Mana Server.
 *
 *  The Mana Server  is free software; you can redistribute  it and/or modify it
 *  under the terms of the GNU General  Public License as published by the Free
 *  Software Foundation; either version 2 of the License, or any later version.
 *
 *  The Mana Server is  distributed in  the hope  that it  will be  useful, but
 *  WITHOUT ANY WARRANTY; without even  the implied warranty of MERCHANTABILITY
 *  or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 *  more details.
 *
 *  You should  have received a  copy of the  GNU General Public  License along
 *  with The Mana Server; if not, write to the  Free Software Foundation, Inc.,
 *  59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 */

require_once(APPPATH.'models/core/Navigation'.EXT);


Interface iTheme
{
    public function beforeLogo();

    public function afterLogo();

    public function Logo();

    public function beforeNavigationBar();

    public function afterNavigationBar();

    public function beforeNavigationBox();

    public function NavigationBox(NavigationBox $box);

    public function afterNavigationBox();
}

abstract class Theme implements iTheme
{
    public function beforeLogo(){}

    public function afterLogo(){}

    public function Logo(){}

    public function beforeNavigationBar(){}

    public function afterNavigationBar(){}

    public function beforeNavigationBox(){}

    public function NavigationBox(NavigationBox $box){}

    public function afterNavigationBox(){}
}

class ThemeInfo
{
    private $errors;

    private $name;
    private $author;
    private $version;
    private $theme;
    private $directory;

    public function ThemeInfo( $themesdir )
    {
        $this->directory = $themesdir;
        $this->errors    = array();
        $this->theme     = null;

        if (!file_exists($themesdir."/theme.xml"))
        {
            $this->errors[] = "File 'theme.xml' not found!";
            return;
        }
        $xml = simplexml_load_file( $themesdir."/theme.xml" );

        $this->name = strval($xml->name[0]);
        $this->author = strval($xml->author[0]);
        $this->version = strval($xml->version[0]);

        $file = strval($xml->scriptfile[0]);
        if (!file_exists($themesdir."/".$file))
        {
            $this->errors[] = sprintf("File '%s' not found!", $file);
            return;
        }

        try
        {
            require_once ($themesdir."/".$file);
            $classname = strval($xml->classname[0]);

            if (!class_exists($classname, false))
            {
                $this->errors[] = sprintf("Themeclass '%s' not found!", $classname);
                return;
            }
            $this->theme = new $classname;
        }
        catch(Exception $e)
        {
            $this->errors[] = sprintf("Error on loading '%s': %s", $file, $e);
        }
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function isValid()
    {
        return (count($this->errors) == 0);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getDirectory()
    {
        return $this->directory;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAuthor()
    {
        return $this->author;
    }
}

?>
