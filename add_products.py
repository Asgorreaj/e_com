import mysql.connector

conn = mysql.connector.connect(
    host='localhost',
    user='root',
    password='',
    database='e_com'
)
cursor = conn.cursor()

# ============================================
# CORRECTED PRODUCT DATA
# ============================================
products = [
    # p_cat_id, cat_id, title, img1, img2, img3, price, desc, keyword
    (22, 7, 'Wireless Bluetooth Headphones', 'headphone.jpg', 'headphone2.jpg', 'headphone3.jpg', 399, 'Premium wireless headphones with noise cancellation', 'wireless headphones'),
    (22, 7, 'Smart Fitness Watch Pro', 'watch.jpg', 'watch2.jpg', 'watch3.jpg', 2499, 'GPS smart watch with heart rate monitor', 'smart watch'),
    (23, 7, '4K Action Camera Ultra', 'camera.jpg', 'camera2.jpg', 'camera3.jpg', 899, 'Waterproof 4K action camera with accessories', 'action camera'),
    (24, 7, '20000mAh Power Bank', 'powerbank.jpg', 'powerbank2.jpg', 'powerbank3.jpg', 299, 'Fast charging portable power bank', 'power bank'),
    (24, 7, 'Wireless Charging Pad', 'charger.jpg', 'charger2.jpg', 'charger3.jpg', 199, 'Qi wireless charging pad for all devices', 'wireless charger'),
    (24, 7, 'USB-C Hub Adapter', 'hub.jpg', 'hub2.jpg', 'hub3.jpg', 349, '7-in-1 USB-C hub with HDMI', 'usb hub'),
    (23, 7, 'Smartphone Tripod', 'tripod.jpg', 'tripod2.jpg', 'tripod3.jpg', 249, 'Flexible smartphone tripod with remote', 'phone tripod'),
    (24, 7, 'LED Desk Lamp', 'desklamp.jpg', 'desklamp2.jpg', 'desklamp3.jpg', 449, 'Eye-caring LED desk lamp with touch control', 'desk lamp'),
    (45, 8, 'Women Summer Floral Dress', 'dress.jpg', 'dress2.jpg', 'dress3.jpg', 799, 'Comfortable summer floral dress', 'summer dress'),
    (45, 8, 'Men Casual Cotton Shirt', 'shirt.jpg', 'shirt2.jpg', 'shirt3.jpg', 549, 'Premium cotton casual shirt for men', 'casual shirt'),
    (46, 8, 'Women Leather Handbag', 'handbag.jpg', 'handbag2.jpg', 'handbag3.jpg', 1299, 'Genuine leather handbag for women', 'leather handbag'),
    (46, 8, 'Men Leather Wallet', 'wallet.jpg', 'wallet2.jpg', 'wallet3.jpg', 349, 'Premium leather wallet with RFID protection', 'leather wallet'),
    (46, 8, 'Women Silk Scarf', 'scarf.jpg', 'scarf2.jpg', 'scarf3.jpg', 299, 'Elegant silk scarf for women', 'silk scarf'),
    (46, 8, 'Men Formal Belt', 'belt.jpg', 'belt2.jpg', 'belt3.jpg', 349, 'Premium leather formal belt for men', 'leather belt'),
    (45, 8, 'Women Sunglasses', 'sunglass.jpg', 'sunglass2.jpg', 'sunglass3.jpg', 549, 'UV protection designer sunglasses', 'sunglasses women'),
    (45, 8, 'Men Sunglasses', 'mensunglass.jpg', 'mensunglass2.jpg', 'mensunglass3.jpg', 499, 'UV protection classic sunglasses for men', 'sunglasses men'),
    (41, 8, 'Vitamin C Face Serum', 'serum.jpg', 'serum2.jpg', 'serum3.jpg', 349, 'Vitamin C face serum for glowing skin', 'face serum'),
    (41, 8, 'Natural Lipstick Set 5pc', 'lipstick_set.jpg', 'lipstick_set2.jpg', 'lipstick_set3.jpg', 499, 'Set of 5 natural lipstick shades', 'lipstick set'),
    (42, 8, 'Herbal Hair Growth Oil', 'hairoil.jpg', 'hairoil2.jpg', 'hairoil3.jpg', 249, 'Herbal hair oil for hair growth', 'hair oil'),
    (41, 8, 'Organic Face Cream', 'facecream.jpg', 'facecream2.jpg', 'facecream3.jpg', 299, '100% organic face cream for glowing skin', 'face cream'),
    (42, 8, 'Natural Nail Polish', 'nailpolish.jpg', 'nailpolish2.jpg', 'nailpolish3.jpg', 199, 'Natural nail polish 5ml', 'nail polish'),
    (42, 8, 'Herbal Body Lotion', 'bodylotion.jpg', 'bodylotion2.jpg', 'bodylotion3.jpg', 249, 'Herbal body lotion for soft skin', 'body lotion'),
    (41, 8, 'Organic Lip Balm', 'lipbalm.jpg', 'lipbalm2.jpg', 'lipbalm3.jpg', 149, 'Organic lip balm with natural ingredients', 'lip balm'),
    (65, 10, 'Pure Organic Honey', 'honey.jpg', 'honey2.jpg', 'honey3.jpg', 299, 'Pure organic honey from natural farms', 'organic honey'),
    (65, 10, 'Premium Arabica Coffee', 'coffee.jpg', 'coffee2.jpg', 'coffee3.jpg', 449, 'Premium Arabica coffee beans', 'coffee beans'),
    (65, 10, 'Healthy Dry Fruits Mix', 'dryfruits.jpg', 'dryfruits2.jpg', 'dryfruits3.jpg', 399, 'Healthy dry fruits mix with nuts', 'dry fruits'),
    (65, 10, 'Natural Green Tea', 'greentea.jpg', 'greentea2.jpg', 'greentea3.jpg', 249, 'Natural green tea with herbs', 'green tea'),
    (65, 10, 'Organic Coconut Oil', 'coconutoil.jpg', 'coconutoil2.jpg', 'coconutoil3.jpg', 299, '100% pure organic coconut oil', 'coconut oil'),
    (65, 10, 'Premium Basmati Rice', 'rice.jpg', 'rice2.jpg', 'rice3.jpg', 299, 'Premium quality basmati rice', 'basmati rice'),
    (56, 9, 'Modern LED Table Lamp', 'lamp.jpg', 'lamp2.jpg', 'lamp3.jpg', 599, 'LED modern table lamp with dimmer', 'table lamp'),
    (56, 9, 'Decorative Wall Clock', 'clock.jpg', 'clock2.jpg', 'clock3.jpg', 699, 'Elegant wall clock for living room', 'wall clock'),
    (57, 9, 'Soft Throw Blanket', 'blanket.jpg', 'blanket2.jpg', 'blanket3.jpg', 449, 'Soft and cozy throw blanket', 'throw blanket'),
    (56, 9, 'Ceramic Coffee Mug Set', 'mug.jpg', 'mug2.jpg', 'mug3.jpg', 249, 'Set of 4 ceramic coffee mugs', 'coffee mug'),
    (57, 9, 'Bamboo Cutting Board', 'board.jpg', 'board2.jpg', 'board3.jpg', 349, 'Bamboo cutting board set', 'cutting board'),
    (56, 9, 'Plant Pot Decorative', 'pot.jpg', 'pot2.jpg', 'pot3.jpg', 299, 'Decorative ceramic plant pot', 'plant pot'),
    (48, 9, 'Kids Educational Toy', 'toy.jpg', 'toy2.jpg', 'toy3.jpg', 299, 'Educational toy for kids learning', 'educational toy'),
    (48, 9, 'Baby Stroller Lightweight', 'stroller.jpg', 'stroller2.jpg', 'stroller3.jpg', 1499, 'Lightweight baby stroller with safety belt', 'baby stroller'),
    (48, 9, 'Kids Story Book Set', 'book.jpg', 'book2.jpg', 'book3.jpg', 249, 'Set of 5 story books for kids', 'story book'),
    (48, 9, 'Baby Soft Toys', 'softtoy.jpg', 'softtoy2.jpg', 'softtoy3.jpg', 199, 'Soft safe toys for babies', 'soft toys'),
    (48, 9, 'Kids Water Bottle', 'waterbottle.jpg', 'waterbottle2.jpg', 'waterbottle3.jpg', 149, 'BPA free kids water bottle', 'kids water bottle'),
    (53, 7, 'Premium Yoga Mat', 'yogamat.jpg', 'yogamat2.jpg', 'yogamat3.jpg', 399, 'Non-slip premium yoga mat', 'yoga mat'),
    (53, 7, 'Dumbbell Set 10kg', 'dumbbell.jpg', 'dumbbell2.jpg', 'dumbbell3.jpg', 899, '10kg dumbbell set for home workout', 'dumbbell set'),
    (53, 7, 'Jump Rope Professional', 'jumprope.jpg', 'jumprope2.jpg', 'jumprope3.jpg', 149, 'Professional jump rope for fitness', 'jump rope'),
    (53, 7, 'Resistance Bands Set', 'bands.jpg', 'bands2.jpg', 'bands3.jpg', 249, 'Set of 5 resistance bands', 'resistance bands'),
    (53, 7, 'Sports Water Bottle', 'sportsbottle.jpg', 'sportsbottle2.jpg', 'sportsbottle3.jpg', 199, 'BPA free sports water bottle', 'sports bottle'),
    (56, 9, 'Classic Backpack', 'backpack.jpg', 'backpack2.jpg', 'backpack3.jpg', 899, 'Classic casual backpack for daily use', 'backpack'),
    (56, 9, 'Slim Laptop Bag', 'laptopbag.jpg', 'laptopbag2.jpg', 'laptopbag3.jpg', 649, 'Slim laptop bag with padding', 'laptop bag'),
    (46, 8, 'Leather Gloves', 'gloves.jpg', 'gloves2.jpg', 'gloves3.jpg', 299, 'Premium leather gloves for winter', 'leather gloves'),
    (46, 8, 'Beanie Hat Winter', 'beanie.jpg', 'beanie2.jpg', 'beanie3.jpg', 199, 'Warm beanie hat for winter', 'beanie hat'),
]

print("=" * 50)
print("  ADDING CORRECTED PRODUCTS")
print("=" * 50)

count = 0
for p in products:
    try:
        cursor.execute("""
            INSERT INTO products 
            (p_cat_id, cat_id, product_title, product_img1, product_img2, product_img3, 
             product_price, product_desc, product_keyword) 
            VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
        """, p)
        count += 1
        print(f"✅ Added: {p[2]}")
    except Exception as e:
        print(f"❌ Error: {p[2]} - {e}")

conn.commit()
conn.close()

print("\n" + "=" * 50)
print(f"✅ Successfully added: {count} products")
print("=" * 50)
print("\n🎉 Done! Check your database.")