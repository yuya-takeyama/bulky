if [ ! -d ./vendor ]; then
  mkdir ./vendor
fi
curl https://raw.github.com/yuya-takeyama/venom/master/venom.php > venom.php
chmod +x venom.php
./venom.php
wget -O ./vendor/SplClassLoader.php https://gist.github.com/jwage/221634/raw/2bc31f04b0ed0ef70daab68516c8d17ba0753f5e/SplClassLoader.php
