NFQ Akademija - Gallery
========================

Installiacija
----------------------------------

Išsiklonuojam repositoriją į norimą katalogą.

Projekte naudojama Symfony2, tam bus reikalingas composeris. Lokaliame kompiuteryje nebūtina turėti, bet galima.

Pasileisti infrastruktūra reikės įsidiegti [virtualbox](1) ir [vagrant](2). Įdiegus vagrant papildomai reikės įdiegti jo papildymą. Tai padaryti galite konsolėje iškvietę komandą:

    $ vagrant plugin install vagrant-hostsupdater
    
Tai sudiegę galime paleisti visą infrastruktūrą. Nueikite į projekto root direktoriją ir paleiskite komandą:

    $ vagrant up
    
Papildomai sudiegti reikalingus paketus ar vėliau patikrinti pasikeitimus infrastruktūrai paleiskite komandą:

    $ vagrant provision
    
Paleiskite paketų atnaujinimą  

    $ composer install
    
Prisijungti prie virtualios mašinos per ssh galima naudojant komandą:

    $ vagrant ssh
    
Kad pamatyti galeriją naršyklėje jums reikės pradinių duomenų, juos gauti reikės prisijungti į ssh ir paleisti keletą komandų. Prisijungus įveskite šias komandas:

    $ vagrant ssh
    $ cd /var/www
    $ php app/console doctrine:database:create 
    $ php app/console doctrine:schema:update --force
    $ php app/console fos:user:create  //šičia pasileis vedlys kurio pagalba sukursite vartotoją ir vėliau galėsite prisijungti
    
Projektą galite atsidaryti naršyklėje suvedę: http://gallery.dev


[1]:  https://www.virtualbox.org/wiki/Downloads
[2]:  http://www.vagrantup.com