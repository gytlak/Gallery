NFQ Akademija - Gallery
========================

Funkcionalumas
----------------------------------

* Autorizacijos sistema (naudojant friendsofsymfony/user-bundle):
    * Prisijungimas.
    * 2 rolės: Admin ir User.
    * Registracija (registruojantis užregistruojama kaip User).
* Failo įkėlimas į serverį (naudojant vich/uploader-bundle).
* Albumai:
    * Kūrimas.
    * Redagavimas.
    * Trynimas (AJAX).
    * Titulinės nuotraukos priskyrimas.
    * Išvedamas nuotraukų skaičius.
* Nuotraukos:
    * Kūrimas.
        * Viena nuotrauka gali būti priskirta keliems albumams.
    * Redagavimas.
    * Trynimas (AJAX).
    * Komentavimas (AJAX).
        * Komentuoti gali tiek Adminas, tiek Useris.
        * Adminas komentarus gali trinti (AJAX).
    * Patikimas (AJAX).
        * Nuotraukos patikti gali tiek Adminui, tiek Useriui, tiek Svečiui.
        * Patikimai saugomi pagal kompiuterio iš kurio siųstas patikimas IP.
    * Tagų prisegimas (AJAX).
        * Nuotraukos puslapyje paspaudus ant tago randamos kitos nuotraukos turinčios tokį tagą.
    * Thumbnail`s sukūrimas ir kešavimas (naudojant avalanche123/imagine-bundle).
    * Nuotraukos atvaizduojamos magnific-popup pagalba, per AJAX iškviečiant nuotraukos view`ą.
    * Peržiūrint nuotrauką rodyklių pagalba galima pereiti į buvusią ar sekančią albumo nuotrauką (AJAX).
    * Išvedami komentarų ir patikimų skaičiai.

Reikalavimai
----------------------------------

* PHP 5.4
* MySQL 5.0
* GD biblioteka
* JSON
* ctype
* php.ini turi turėti date.timezone nustatymą
* Composer (vendoriams parsisiųsti)

Live demo
----------------------------------

Projekto demo internete:
http://www.gallery.96.lt