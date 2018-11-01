AiO CMS
===

Приложение позволяет разбить исследуемую территорию на необходимое и удобное количество секторов; отслеживать количество автомобилей в заданные промежутки времени путём введения номерных знаков автомобилей, расположенных в секторе. Введённая информация автоматически анализируется и выдаётся в виде двух графиков: время простаивания автомобилей к их количеству и количество автомобилей к заданному времени суток.

Приложение разработано Mozgami studio и AiO IT company при финансовой поддержке Европейского Союза. Содержание сайта является предметом ответственности «Минской урбанистической платформы» и может не отражать точку зрения Европейского Союза.



    composer install
    app/console doctrine:database:create --if-not-exists
    app/console doctrine:schema:update --dump-sql
    app/console doctrine:schema:update --force
    app/console doctrine:fixtures:load
    app/console sonata:media:fix-media-context
    app/console fos:user:create --super-admin admin admin@gmail.com password || echo 'admin is exists'
    mkdir -p web/uploads
    setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs web/uploads
    setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs web/uploads
    app/console cache:clear
    app/console assets:install

