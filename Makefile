
init:
	sudo apt install -y php8.2 php8.2-mbstring php8.2-imagick php8.2-dom php8.2-xml fonts-ipaexfont
	# composer
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"
	sudo mv composer.phar /usr/local/bin/composer

composer:
	composer install

lsusb:
	lsusb

add-permission:
	sudo chmod 666 /dev/usb/lp0

test: 
	docker compose run --rm php vendor/bin/phpunit tests
