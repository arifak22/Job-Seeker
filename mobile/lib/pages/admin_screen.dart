import 'package:flutter/material.dart';
import 'package:mobile/helpers/bottom_bar.dart';
import 'package:mobile/helpers/color.dart';
import 'dart:io' show Platform;
import 'package:mobile/helpers/services.dart';
import 'package:mobile/pages/home/main_screen.dart' as home;
import 'package:mobile/pages/profile_screen.dart';
import 'package:line_awesome_flutter/line_awesome_flutter.dart';
import 'package:shared_preferences/shared_preferences.dart';

import 'package:mobile/pages/admin/main_screen.dart' as admin;
import 'package:mobile/pages/pencarikerja/main_screen.dart' as pencarikerja;
import 'package:mobile/pages/perusahaan/main_screen.dart' as perusahaan;


import 'package:mobile/pages/admin/verifikasi_kartu.dart';


class AdminScreen extends StatefulWidget {
  dynamic id_privilege;

  AdminScreen({required this.id_privilege});

  @override
  _AdminScreenState createState() => _AdminScreenState(id_privilege);
}

class _AdminScreenState extends State<AdminScreen> {
  _AdminScreenState(dynamic id_privilege);
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
    checkIsNotLoggedIn();

  }
  void checkIsNotLoggedIn()async{
    var preferences = await SharedPreferences.getInstance();
    if (preferences.getString('token') == null) {
      Navigator.pushNamedAndRemoveUntil(context, '/', (Route route)=>false);
    }
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

  final List<List<Widget>> _children = [
    [home.MainScreen(),pencarikerja.MainScreen(),ProfileScreen()], //pencari kerja
    [home.MainScreen(),perusahaan.MainScreen(),ProfileScreen()], //perusahaan
    [VerifikasiKartu(),admin.MainScreen(),ProfileScreen()], //admin
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
          children: _children[widget.id_privilege - 1],
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
              icon: Icon(LineAwesomeIcons.inbox),
              title: Text('Dashboard'),
              activeColor: Color.fromARGB(255, 19, 49, 166),
          ),
          BottomNavyBarItem(
              icon: Icon(LineAwesomeIcons.user),
              title: Text('Profil'),
              activeColor: Color.fromARGB(255, 19, 49, 166),
          ),
        ],
      )
    );
  }

}