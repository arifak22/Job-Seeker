import 'package:flutter/material.dart';
import 'package:line_awesome_flutter/line_awesome_flutter.dart';
import 'package:mobile/helpers/widget.dart';

class MainScreen extends StatefulWidget {
  @override
  _MainScreenState createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {

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
                    Container(
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.all(Radius.circular(10)),
                        color: Colors.white,
                      ),
                      padding: EdgeInsets.all(15),
                      margin: EdgeInsets.symmetric(vertical: 5),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Row(
                            children: [
                              Icon(LineAwesomeIcons.search_location, color: Color.fromARGB(255,17,62,108),),
                              Text('    '),
                              Text('Lowongan Kerja', style: TextStyle(color: Color.fromARGB(255,17,62,108), fontSize: 15),),
                            ],
                          ),
                          Text('20', style: TextStyle(color:  Color.fromARGB(255, 51,178,124), fontWeight: FontWeight.bold, fontSize: 15),)
                        ]
                      ),
                    ),
                    Container(
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.all(Radius.circular(10)),
                        color: Colors.white,
                      ),
                      padding: EdgeInsets.all(15),
                      margin: EdgeInsets.symmetric(vertical: 5),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Row(
                            children: [
                              Icon(LineAwesomeIcons.building, color: Color.fromARGB(255,17,62,108),),
                              Text('    '),
                              Text('Perusahaan', style: TextStyle(color: Color.fromARGB(255,17,62,108), fontSize: 15),),
                            ],
                          ),
                          Text('4', style: TextStyle(color:  Color.fromARGB(255, 51,178,124), fontWeight: FontWeight.bold, fontSize: 15),)
                        ]
                      ),
                    ),
                    Container(
                      decoration: BoxDecoration(
                        borderRadius: BorderRadius.all(Radius.circular(10)),
                        color: Colors.white,
                      ),
                      padding: EdgeInsets.all(15),
                      margin: EdgeInsets.symmetric(vertical: 5),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Row(
                            children: [
                              Icon(LineAwesomeIcons.users, color: Color.fromARGB(255,17,62,108),),
                              Text('    '),
                              Text('Pencari Kerja', style: TextStyle(color: Color.fromARGB(255,17,62,108), fontSize: 15),),
                            ],
                          ),
                          Text('70', style: TextStyle(color:  Color.fromARGB(255, 51,178,124), fontWeight: FontWeight.bold, fontSize: 15),)
                        ]
                      ),
                    ),
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