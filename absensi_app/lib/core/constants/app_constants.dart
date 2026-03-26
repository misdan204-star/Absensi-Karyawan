class AppConstants {
  static const String baseUrl = 'http://10.0.2.2:8000'; // For Android Emulator
  // For physical device, use your machine's local IP (e.g., 192.168.1.x)
  
  static const String loginEndpoint = '$baseUrl/api/login';
  static const String profileEndpoint = '$baseUrl/api/user';
  static const String attendanceEndpoint = '$baseUrl/api/absen';
  static const String historyEndpoint = '$baseUrl/api/history';
}
