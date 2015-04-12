KTU - Gallery
========================

Funkcionalumas
----------------------------------

* Autorizacijos sistema (naudojant friendsofsymfony/user-bundle):
    * Prisijungimas.
    * 3 rolės: administratorius, paprastas naudotojas ir svečias.
    * Registracija (registruojantis užregistruojama kaip paprastas naudotojas).
* Failo įkėlimas į serverį (naudojant vich/uploader-bundle).
* Albumai:
    * Kūrimas.
    * Redagavimas.
    * Trynimas (AJAX).
    * Titulinės nuotraukos priskyrimas.
* Nuotraukos:
    * Kūrimas.
        * Viena nuotrauka gali būti priskirta keliems albumams.
    * Redagavimas.
    * Trynimas (AJAX).
    * Komentavimas (AJAX).
        * Komentuoti gali tiek administratorius, tiek paprastas naudotojas.
        * Administratorius komentarus gali trinti (AJAX).
    * Patikimas (AJAX).
        * Nuotraukos patikti gali administratoriui, paprastam naudotojui ir svečiui.
        * Patikimai saugomi pagal kompiuterio iš kurio siųstas patikimas IP.
    * "Tagų" prisegimas (AJAX).
        * Nuotraukos puslapyje paspaudus ant "tago" randamos kitos nuotraukos turinčios tokį "tagą".
        * Nuotraukų paieška pagal "tagą".
    * Miniatiūrų sukūrimas ir kešavimas (naudojant avalanche123/imagine-bundle).
    * Nuotraukos atvaizduojamos magnific-popup pagalba, per AJAX iškviečiant nuotraukos "viewą".
    * Peržiūrint nuotrauką rodyklių pagalba galima pereiti į buvusią ar sekančią albumo nuotrauką (AJAX).

Reikalavimai
----------------------------------

* PHP 5.4
* MySQL 5.0
* GD biblioteka
* JSON
* ctype
* php.ini turi turėti date.timezone nustatymą

Live demo
----------------------------------

Projekto demo internete:
http://gallery.gytis.me
