
init:
	sudo apt install -y php php-mbstring php-imagick fonts-ipaexfont
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
