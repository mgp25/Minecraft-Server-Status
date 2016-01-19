# ![dirt](http://i51.tinypic.com/2lx73o6.jpg)Minecraft Server Status

This library can be used to query Minecraft servers for some basic information and player's skin.

You will be able to retrieve:

- Server's version
- Number of players online
- Server status
- Server's description
- Server's image
- Mods installed in the server
- Player's skin and face

### Examples
```php
<?php
    require __DIR__ . '/src/MinecraftPing.php';
    require __DIR__ . '/src/MinecraftPingException.php';
    try
    {
        $Query = new MinecraftPing( 'localhost', 25565 );

        print_r( $Query->Query() );
    }
    catch( MinecraftPingException $e )
    {
        echo $e->getMessage();
    }
    finally
    {
        $Query->Close();
    }
```

```php
<?php
require __DIR__ . '/src/MinecraftSkin.php';

$mc = new MinecraftSkin();
$mc->getFace('mgp25'); // image is downloaded and stored in /faces, path is returned
```
