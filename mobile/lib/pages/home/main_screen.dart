import 'package:flutter/material.dart';
import 'package:line_awesome_flutter/line_awesome_flutter.dart';
import 'package:mobile/helpers/services.dart';
import 'package:mobile/helpers/widget.dart';
import 'package:mobile/pages/home/loker_screen.dart';

class MainScreen extends StatefulWidget {
  @override
  _MainScreenState createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  dynamic totalLoker = '-';
  getTotalLoker() async{
    if(!mounted) return;
    return await Services().getApi('loker', 'tipe=home').then((value) {
        if(value['api_status'] == 1){
            return value['data'].toString();
        }else{
          return '-';
        }
      }
    );
  }

  @override
  void initState() {
    // TODO: implement initState
    super.initState();
    totalLoker = getTotalLoker();
  }

  @override
  void dispose() {
    // TODO: implement dispose
    super.dispose();
    // getTotalLoker().dispose();
  }
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // appBar: appBar('Beranda'),
      body: Container(
        width: double.infinity,
        height: double.infinity,
        color: Color.fromARGB(255,39,82,159),
        child: Container(
          decoration: BoxDecoration(
              borderRadius: BorderRadius.only(topLeft: Radius.circular(35), topRight: Radius.circular(35)),
              color: Color.fromARGB(255, 241, 241, 243),
          ),
          margin: EdgeInsets.only(top: 50),
          padding:  EdgeInsets.all(30),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.start,
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Container(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.start,
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Container(
                      margin: EdgeInsets.only(bottom: 5),
                      child: Text('Selamat Datang', 
                              style: TextStyle(color: Color.fromARGB(255,17,62,108), fontSize: 25, fontWeight: FontWeight.w900)),
                    ),

                    Text('Di SIAPNARI (Sistem Aplikasi Tenaga Kerja & Perindustrian)', 
                            style: TextStyle(color: Color.fromARGB(255,17,62,108), fontSize: 15, fontWeight: FontWeight.w600)),
                    FutureBuilder(future: totalLoker, builder: (BuildContext context, AsyncSnapshot<dynamic> snapshot) {
                      String title = snapshot.hasData ? snapshot.data.toString() : '-';
                      return BarMenu(
                        icon : LineAwesomeIcons.search_location,
                        label: 'Lowongan Kerja',
                        info : Text(title, style: TextStyle(color:  Color.fromARGB(255, 51,178,124), fontWeight: FontWeight.bold, fontSize: 15)),
                        onTap: (){
                          Navigator.push(
                            context,
                            MaterialPageRoute(builder: (context) => LokerScreen()),
                          );
                        }
                      );
                    }),
                  ],
                )
              )
            ],
          ),
        ),
      )
    );
  }

}