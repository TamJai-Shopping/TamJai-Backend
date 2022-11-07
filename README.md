## แนะนำโปรเจค
 ระบบ Tam jai (ตาม-ใจ) เป็นโปรเจคเว็บไซต์สำหรับซื้อขายสินค้า โดยในหน้าเว็บจะมีสินค้าหลายหมวดหมู่ที่วางขายอยู่ ผู้ใช้สามารถกดเลือกซื้อสินค้า หรือเปิดร้านค้าเพื่อขายในเว็บไซต์นี้ได้

## ชื่อกลุ่ม และรายชื่อสมาชิกในกลุ่ม
 
### กลุ่ม Tam-Jai (ทำใจ)
- รหัสนิสิต-ชื่อนามสกุล 6310450051 ลีโอณิช เช็ง 
GitHub: KenzieLeonic 
- รหัสนิสิต-ชื่อนามสกุล 6310450484 ณภัทร พัชโรภาสวงศ์ 
GitHub: aungpor 
- รหัสนิสิต-ชื่อนามสกุล 6310450522 ธนบดี กังวลกิจ 
GitHub: nax200 
- รหัสนิสิต-ชื่อนามสกุล 6310450620 พุธิตา จองศิริกุล 
GitHub: ployputita 
- รหัสนิสิต-ชื่อนามสกุล 6310451120 ณัฐพงษ์ เหล่าเราวัฒนกุล 
GitHub: S-Nattapong 
- รหัสนิสิต-ชื่อนามสกุล 630451294 พชร สุวราวรนาถ 
GitHub: Irisia

## คำแนะนำในการติดตั้งโปรเจค
> require: ต้องติดตั้ง docker และเปิดใช้งานอยู่
1. change directory ไปที่ ๆ ต้องการติดตั้ง
2. ใช้คำสั่งในการโหลดโปรเจค
```sh
git clone https://github.com/TamJai-Shopping/TamJai-Backend.git
```
3. ใช้คำสั่งกำหนด keyword ในการรัน ด้วย
```sh
alias sail='./vendor/bin/sail'
```
4. `cp .env.example .env`
5.
```sh
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
6. `sail up -d` เพื่อรันโปรเจคในรูปแบบ background
7. `sail artisan key:generate`
8. สร้างฐานข้อมูล `sail artisan migrate:fresh` หากต้องการให้จำลองข้อมูลด้วยให้ใส่ `--seed` ที่ด้านหลัง


- docker-compose up -d
- docker-compose exec app npm install
- docker-compose exec app npm run dev

## คำแนะนำในการติดตั้งโปรเจคสำหรับ deploy



## คำแนะนำในการรันโปรเจคหรือการเข้าถึงหน้าเว็บไซต์
> require: ต้องรันโปรเจคที่ front-end ก่อน <br>
เข้าผ่าน url [http://localhost:3000](http://localhost:3000)



## default username และ password สำหรับผู้ใช้แต่ละ role

- Role user
- Email: user01@api.example.com
- Password: userpass
-----------------------------------
- Role Admin
- Email: admin@api.example.com
- Password: adminpass

## ระบุ release tag ของโปรเจคที่สมบูรณ์ ใช้ในการนำเสนอ
> v1.0.0
