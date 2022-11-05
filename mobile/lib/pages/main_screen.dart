import 'package:flutter/material.dart';
import 'package:mobile/helpers/bottom_bar.dart';
import 'package:mobile/helpers/color.dart';
import 'dart:io' show Platform;
import 'package:mobile/helpers/services.dart';
import 'package:mobile/pages/home/main_screen.dart' as home;
import 'package:line_awesome_flutter/line_awesome_flutter.dart';

class MainScreen extends StatefulWidget {
  @override
  _MainScreenState createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  late PageController _pageController;


  @override
  void dispose() {
    _pageController.dispose();
    super.dispose();
  }
  @override
  void initState() {
    super.initState();
    // Use either of them. 
    Future(_showDialog);
    _pageController = PageController();

  }

  String getPlatform() {
    if (Platform.isIOS) {
      return 'iOS_version';
    } else if (Platform.isAndroid) {
      return 'android_version';
    } else if (Platform.isFuchsia) {
      return 'Fuchsia';
    } else if (Platform.isLinux) {
      return 'Linux';
    } else if (Platform.isMacOS) {
      return 'MacOS';
    } else if (Platform.isWindows) {
      return 'Windows';
    }
    return '-';
  }

  void _showDialog() {
    // flutter defined function
    String platform = getPlatform();
    String version  = appVersion();
    Services().getApi('version', 'version=${version}&platform=${platform}').then((val) {
      if (val['api_status'] == 1) {
        if(val['update']){
          showDialog(
            context: context,
            builder: (BuildContext context) {
              // return object of type Dialog
              return AlertDialog(
                title: Text("Update ke Versi ${val['version']}"),
                content: SizedBox(
                  width: double.maxFinite,
                  child: ListView.builder(
                    shrinkWrap: true,
                    itemCount: val['update_message'].length,
                    itemBuilder: (context, i){
                      return Text('- ' + val['update_message'][i]);
                    },
                  ),
                ),
                actions: <Widget>[
                  // usually buttons at the bottom of the dialog
                   TextButton(
                    child:  const Text("Close"),
                    onPressed: () {
                      Navigator.of(context).pop();
                    },
                  ),
                ],
              );
            },
          );
        }
      }else{
        showDialog(context: context, builder: (_) =>AlertDialog(
          title: const Text('Something wrong'),
          content: Text('${val['api_message']}'),
          actions: <Widget>[ElevatedButton(onPressed: ()=>Navigator.pop(context), child: const Text('Ok'))],
        ));
        print('gagal');
      }
      print(val);
    });
  }

  int _currentIndex = 0;

  final List<Widget> _children = [
    home.MainScreen(),
    const Text('Login'),
    const Text('Login'),
    const Text('Login'),
  ];
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SizedBox.expand(
        child: PageView(
          controller: _pageController,
          onPageChanged: (index) {
            setState(() => _currentIndex = index);
          },
          children: _children,
        ),
      ),
      bottomNavigationBar: BottomNavyBar(
        selectedIndex: _currentIndex,
        showElevation: true, // use this to remove appBar's elevation
        onItemSelected: (index) => setState(() {
          _currentIndex = index;
          _pageController.animateToPage(index,
              duration: Duration(milliseconds: 300), curve: Curves.ease);
        }),
        items: [
          BottomNavyBarItem(
            icon: Icon(LineAwesomeIcons.home),
            title: Text('Beranda'),
            activeColor: Color.fromARGB(255, 19, 49, 166),
          ),
          BottomNavyBarItem(
              icon: Icon(LineAwesomeIcons.alternate_sign_in),
              title: Text('Login'),
              activeColor: Color.fromARGB(255, 19, 49, 166),
          ),
        ],
      )
    );
  }

}