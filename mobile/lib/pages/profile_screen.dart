import 'package:flutter/material.dart';
import 'package:line_awesome_flutter/line_awesome_flutter.dart';
import 'package:mobile/helpers/color.dart';
import 'package:mobile/helpers/services.dart';
import 'package:mobile/helpers/widget.dart';
import 'package:progress_dialog/progress_dialog.dart';
import 'package:shared_preferences/shared_preferences.dart';

class ProfileScreen extends StatefulWidget {
  @override
  _ProfileScreenState createState() => _ProfileScreenState();
}

class _ProfileScreenState extends State<ProfileScreen> {
  late ProgressDialog pr;


  Future<void> submitLogout() async {
    pr.show();
    // var fcm    = await Services().getSession('fcm');
    var data = {
      'null'             : '0',
    };
    Services().postApi('logout', data).then((val) async {
      pr.hide();
      if (val['api_status'] == 1) {
        SharedPreferences preferences = await SharedPreferences.getInstance();
        preferences.clear();
        Navigator.pushNamedAndRemoveUntil(context, '/', (Route route)=>false);
      }else{
        showDialog(context: context, builder: (_) =>AlertDialog(
          title: Text('Something wrong'),
          content: Text('${val['api_message']}'),
          actions: <Widget>[ElevatedButton(onPressed: ()=>Navigator.pop(context), child: Text('Ok'))],
        ));
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    pr = new ProgressDialog(context, type: ProgressDialogType.Normal);
    pr.style(
      message: 'Menunggu...',
      borderRadius: 5.0,
      backgroundColor: Colors.white,
      elevation: 10.0,
      insetAnimCurve: Curves.easeInOut,
      progress: 0.0,
      maxProgress: 100.0,
      progressTextStyle: TextStyle(
          color: Colors.black, fontSize: 13.0, fontWeight: FontWeight.w400),
      messageTextStyle: TextStyle(
          color: Colors.black, fontSize: 19.0, fontWeight: FontWeight.w600),
    );
    final Color background =  Color.fromARGB(255,39,82,159);
    final Color fill = MyColor('bg');
    final List<Color> gradient = [
      background,
      background,
      fill,
      fill,
    ];
    final double fillPercent = 80.00; // fills 56.23% for container from bottom
    final double fillStop = (100 - fillPercent) / 100;
    final List<double> stops = [0.0, fillStop, fillStop, 1.0];
    return Scaffold(
      // appBar: AppBar(
      //   title          : Text('Profil', style: TextStyle(color: Colors.white, fontSize: 25)),
      //   elevation      : 0,
      //   iconTheme: IconThemeData(
      //     color: Colors.white, //change your color here
      //   ),
      //   backgroundColor: Color.fromARGB(255,39,82,159),
      // ),
      appBar: AppBar(
        elevation      : 0,
        iconTheme: IconThemeData(
          color: Colors.white, //change your color here
        ),
        backgroundColor: Color.fromARGB(255,39,82,159),
      title: 
        Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          crossAxisAlignment: CrossAxisAlignment.end,
          children: [
          Expanded(flex: 1,child: Text('', textAlign: TextAlign.start, style: TextStyle(color: Colors.white, fontSize: 14))),
          Expanded(flex: 1,child: Text('Profil', textAlign: TextAlign.center, style: TextStyle(color: Colors.white, fontSize: 25))),
          Expanded(flex: 1,child: Container(alignment: Alignment.bottomRight,child: TextButton(onPressed: (){submitLogout();},child: Text('Logout', textAlign: TextAlign.end, style: TextStyle(color: Colors.white, fontSize: 14))))),
        ]),
    ),
      body: Container(
        decoration: BoxDecoration(
          gradient: LinearGradient(
            colors: gradient,
            stops: stops,
            end: Alignment.bottomCenter,
            begin: Alignment.topCenter,
          ),
        ),
        alignment: Alignment.center,
        // color:  Color.fromARGB(255,39,82,159),
        child: Column(
          children: [
            // Container(
            //   margin: EdgeInsets.only(top: 50, left: 50, right: 50, bottom: 15),
            //   height: 50,
            //   child: Row(
            //     children: [
            //       Text('Ubah Profil'),
            //       Text('Profil'),
            //       Text('Logout'),
            //   ]
            //   ),
            // ),
            Expanded(
              flex: 2,
              child:  Column(
              crossAxisAlignment: CrossAxisAlignment.center,
              mainAxisAlignment: MainAxisAlignment.center,
              children: <Widget>[
                Container(
                width: 160.0,
                height: 160.0,
                alignment: Alignment.center,
                decoration:  BoxDecoration(
                  color: Colors.white,
                  shape: BoxShape.circle,
                ),
                child:Container(
                    width: 150.0,
                    height: 150.0,
                    decoration:  BoxDecoration(
                      shape: BoxShape.circle,
                      image:  DecorationImage(
                          fit: BoxFit.fill,
                          image:  NetworkImage(
                              "https://www.w3schools.com/howto/img_avatar.png")
                      )
                    )
                  )
                 ),
                 Text("Arif Kurniawan",
                    textScaleFactor: 1.5, style: TextStyle(fontSize: 16, fontWeight: FontWeight.w700),),
                  Text("Pencari Kerja",
                  textScaleFactor: 1.5, style: TextStyle(fontSize: 12))
              ],
            )
            ),
            Expanded(
              flex: 3,
              child: Text('')
            ),
          ],
        )
      ),
    );
  }
}