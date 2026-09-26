class Product {
final int id;
final String name;
final String description;
final double price;
final int stock;
final String? image; 
final int? categoryId;
final int? vendeurId;
final String? categoryName;
const Product({
required this.id,
required this.name,
required this.description,
required this.price,
required this.stock,
this.image,
this.categoryId,
this.vendeurId,
this.categoryName,
});
factory Product.fromJson(Map<String, dynamic> json) {
return Product(
id: int.tryParse(json['id'].toString()) ?? 0,
name: json['nom']?.toString() ?? '',
description:
json['description']?.toString() ?? '',
price:
double.tryParse(json['prix'].toString()) ?? 0.0,
stock:
int.tryParse(json['stock'].toString()) ?? 0,
image: json['image']?.toString(),
categoryId: json['category_id'] != null
? int.tryParse(json['category_id'].toString())
: null,
vendeurId: json['vendeur_id'] != null
? int.tryParse(json['vendeur_id'].toString())
: null,
categoryName: json['category'] != null
? json['category']['nom']?.toString()
: null,
);
}
bool get isAvailable => stock > 0;
String? get imageUrl {
if (image == null || image!.isEmpty) {
return null;
}
if (image!.startsWith('http')) {
return image;
}
return 'http://10.0.2.2:8000/storage/$image';
}
}