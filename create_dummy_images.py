from PIL import Image, ImageDraw, ImageFont
import os

# ============================================
# CREATE DUMMY IMAGES FOR ALL PRODUCTS
# ============================================

# ফোল্ডার তৈরি করুন
img_folder = "admin_area/product_images/"
if not os.path.exists(img_folder):
    os.makedirs(img_folder)

# প্রোডাক্ট ইমেজ ফাইলের নাম
product_images = [
    'headphone.jpg', 'headphone2.jpg', 'headphone3.jpg',
    'watch.jpg', 'watch2.jpg', 'watch3.jpg',
    'camera.jpg', 'camera2.jpg', 'camera3.jpg',
    'powerbank.jpg', 'powerbank2.jpg', 'powerbank3.jpg',
    'charger.jpg', 'charger2.jpg', 'charger3.jpg',
    'hub.jpg', 'hub2.jpg', 'hub3.jpg',
    'tripod.jpg', 'tripod2.jpg', 'tripod3.jpg',
    'desklamp.jpg', 'desklamp2.jpg', 'desklamp3.jpg',
    'dress.jpg', 'dress2.jpg', 'dress3.jpg',
    'shirt.jpg', 'shirt2.jpg', 'shirt3.jpg',
    'handbag.jpg', 'handbag2.jpg', 'handbag3.jpg',
    'wallet.jpg', 'wallet2.jpg', 'wallet3.jpg',
    'scarf.jpg', 'scarf2.jpg', 'scarf3.jpg',
    'belt.jpg', 'belt2.jpg', 'belt3.jpg',
    'sunglass.jpg', 'sunglass2.jpg', 'sunglass3.jpg',
    'mensunglass.jpg', 'mensunglass2.jpg', 'mensunglass3.jpg',
    'serum.jpg', 'serum2.jpg', 'serum3.jpg',
    'lipstick_set.jpg', 'lipstick_set2.jpg', 'lipstick_set3.jpg',
    'hairoil.jpg', 'hairoil2.jpg', 'hairoil3.jpg',
    'facecream.jpg', 'facecream2.jpg', 'facecream3.jpg',
    'nailpolish.jpg', 'nailpolish2.jpg', 'nailpolish3.jpg',
    'bodylotion.jpg', 'bodylotion2.jpg', 'bodylotion3.jpg',
    'lipbalm.jpg', 'lipbalm2.jpg', 'lipbalm3.jpg',
    'honey.jpg', 'honey2.jpg', 'honey3.jpg',
    'coffee.jpg', 'coffee2.jpg', 'coffee3.jpg',
    'dryfruits.jpg', 'dryfruits2.jpg', 'dryfruits3.jpg',
    'greentea.jpg', 'greentea2.jpg', 'greentea3.jpg',
    'coconutoil.jpg', 'coconutoil2.jpg', 'coconutoil3.jpg',
    'rice.jpg', 'rice2.jpg', 'rice3.jpg',
    'lamp.jpg', 'lamp2.jpg', 'lamp3.jpg',
    'clock.jpg', 'clock2.jpg', 'clock3.jpg',
    'blanket.jpg', 'blanket2.jpg', 'blanket3.jpg',
    'mug.jpg', 'mug2.jpg', 'mug3.jpg',
    'board.jpg', 'board2.jpg', 'board3.jpg',
    'pot.jpg', 'pot2.jpg', 'pot3.jpg',
    'toy.jpg', 'toy2.jpg', 'toy3.jpg',
    'stroller.jpg', 'stroller2.jpg', 'stroller3.jpg',
    'book.jpg', 'book2.jpg', 'book3.jpg',
    'softtoy.jpg', 'softtoy2.jpg', 'softtoy3.jpg',
    'waterbottle.jpg', 'waterbottle2.jpg', 'waterbottle3.jpg',
    'yogamat.jpg', 'yogamat2.jpg', 'yogamat3.jpg',
    'dumbbell.jpg', 'dumbbell2.jpg', 'dumbbell3.jpg',
    'jumprope.jpg', 'jumprope2.jpg', 'jumprope3.jpg',
    'bands.jpg', 'bands2.jpg', 'bands3.jpg',
    'sportsbottle.jpg', 'sportsbottle2.jpg', 'sportsbottle3.jpg',
    'backpack.jpg', 'backpack2.jpg', 'backpack3.jpg',
    'laptopbag.jpg', 'laptopbag2.jpg', 'laptopbag3.jpg',
    'gloves.jpg', 'gloves2.jpg', 'gloves3.jpg',
    'beanie.jpg', 'beanie2.jpg', 'beanie3.jpg',
]

# রঙের তালিকা
colors = [
    '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7',
    '#DDA0DD', '#98D8C8', '#F7DC6F', '#BB8FCE', '#F1948A',
    '#82E0AA', '#85C1E9', '#F8C471', '#D7BDE2', '#A3E4D7',
    '#FAD7A0', '#AED6F1', '#D5F5E3', '#FADBD8', '#D6EAF8'
]

print("=" * 50)
print("  CREATING DUMMY PRODUCT IMAGES")
print("=" * 50)

count = 0
for img_name in product_images:
    try:
        # 400x400 ইমেজ তৈরি করুন
        img = Image.new('RGB', (400, 400), color=colors[count % len(colors)])
        draw = ImageDraw.Draw(img)
        
        # টেক্সট যোগ করুন
        try:
            font = ImageFont.truetype("arial.ttf", 30)
        except:
            font = ImageFont.load_default()
        
        # প্রোডাক্টের নাম (ফাইল নাম থেকে)
        name = img_name.replace('.jpg', '').replace('2', '').replace('3', '')
        draw.text((50, 180), name[:20].upper(), fill='white', font=font)
        draw.text((50, 220), "SHOPIXIA", fill='white', font=font)
        
        # সেভ করুন
        img.save(img_folder + img_name)
        count += 1
        print(f"✅ Created: {img_name}")
        
    except Exception as e:
        print(f"❌ Error creating {img_name}: {e}")

print("\n" + "=" * 50)
print(f"✅ Successfully created: {count} images")
print("=" * 50)
print("\n🎉 All dummy images created!")