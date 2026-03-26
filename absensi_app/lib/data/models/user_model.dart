class UserModel {
  final int id;
  final String name;
  final String email;
  final String? nik;
  final String? department;
  final String? phone;
  final String? address;
  final String? profilePhotoPath;
  final String role;

  UserModel({
    required this.id,
    required this.name,
    required this.email,
    this.nik,
    this.department,
    this.phone,
    this.address,
    this.profilePhotoPath,
    required this.role,
  });

  factory UserModel.fromJson(Map<String, dynamic> json) {
    return UserModel(
      id: json['id'],
      name: json['name'],
      email: json['email'],
      nik: json['nik'],
      department: json['department'],
      phone: json['phone'],
      address: json['address'],
      profilePhotoPath: json['profile_photo_path'],
      role: json['role'] ?? 'employee',
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'email': email,
      'nik': nik,
      'department': department,
      'phone': phone,
      'address': address,
      'profile_photo_path': profilePhotoPath,
      'role': role,
    };
  }
}
