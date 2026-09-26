import 'package:flutter/material.dart';
import 'services/product_service.dart';
void main() {
 runApp(const MyApp());
}
class MyApp extends StatelessWidget {
 const MyApp({super.key});
 @override
 Widget build(BuildContext context) {
 return MaterialApp(
 debugShowCheckedModeBanner: false,
 home: Scaffold(
 appBar: AppBar(
 title: const Text('Test API Laravel'),
 ),
 body: FutureBuilder(
 future: ProductService.getProducts(),
 builder: (context, snapshot) {
 if (snapshot.connectionState ==
 ConnectionState.waiting) {
 return const Center(
 child:
 CircularProgressIndicator(),
 );
 }
 if (snapshot.hasError) {
 return Center(
 child: Text(
 'Erreur : ${snapshot.error}',
 ),
 );
 }
 final products =
 snapshot.data ?? [];
 return ListView.builder(
 itemCount: products.length,
 itemBuilder: (context, index) {
 final product =
 products[index];
 return ListTile(
 title: Text(product.name),
subtitle: Text(
 '${product.price} €',
 ),
 );
 },
 );
 },
 ),
 ),
 );
 }
}

