import 'dart:convert';
import 'package:http/http.dart' as http;
import '../config/api_config.dart';
import '../models/product.dart';
class ProductService {
 static Future<List<Product>> getProducts() async {
 final url = Uri.parse(
'${ApiConfig.baseUrl}/products',
 );
 final response = await http.get(
 url,
 headers: {
 'Accept': 'application/json',
 },
 );
 if (response.statusCode != 200) {
 throw Exception(
 'Erreur API : ${response.statusCode}',
 );
 }
 final dynamic decoded =
 jsonDecode(response.body);
 final List<dynamic> data;
 if (decoded is List) {
 data = decoded;
 } else {
 data = decoded['data'] ?? [];
 }
 return data
 .map(
 (json) => Product.fromJson(json),
 )
 .toList();
 }
}
