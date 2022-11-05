import 'package:flutter/material.dart';
import 'package:mobile/helpers/services.dart';
import 'package:mobile/helpers/color.dart';


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
        scaffoldBackgroundColor: MyColor('bg'),
        buttonColor            : MyColor('primary'),
        primaryColor           : MyColor('default'),
      ),
      routes: <String, WidgetBuilder>{
         '/'        : (context) => MainScreen(),
      },
    );
  }
}
