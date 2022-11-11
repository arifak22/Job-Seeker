import 'package:flutter/material.dart';
import 'package:mobile/helpers/services.dart';
import 'package:mobile/helpers/color.dart';
import 'package:mobile/pages/admin_screen.dart';

import 'package:mobile/pages/main_screen.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});
  

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    final GlobalKey<NavigatorState> navigatorKey = GlobalKey(debugLabel: "Main Navigator");
    return MaterialApp(
      title                     : 'SIAPNARI',
      // debugShowMaterialGrid     : isDebug(),
      navigatorKey: navigatorKey,
      debugShowCheckedModeBanner: isDebug(),
      theme                     : ThemeData(
        scaffoldBackgroundColor: Color.fromARGB(255, 241, 241, 243),
        buttonColor            : MyColor('primary'),
        primaryColor           : MyColor('default'),
      ),
      routes: <String, WidgetBuilder>{
         '/'       : (context) => MainScreen(),
         '/login/3': (context) => AdminScreen(id_privilege: 3), //admin
         '/login/2': (context) => AdminScreen(id_privilege: 2), //perusahaan
         '/login/1': (context) => AdminScreen(id_privilege: 1), //pencari kerja
      },
    );
  }
}
