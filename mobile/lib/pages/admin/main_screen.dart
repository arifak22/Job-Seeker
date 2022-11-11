import 'package:flutter/material.dart';
import 'package:line_awesome_flutter/line_awesome_flutter.dart';
import 'package:mobile/helpers/icon_image_provider.dart';
import 'package:mobile/helpers/widget.dart';
import 'package:mobile/pages/admin/lowongan_kerja.dart';
import 'package:mobile/pages/admin/verifikasi_kartu.dart';

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
                  margin: EdgeInsets.only(bottom: 20),
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.start,
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Container(
                        margin: EdgeInsets.only(bottom: 5),
                        child: Text('Dashboard', 
                                style: TextStyle(color: Color.fromARGB(255,17,62,108), fontSize: 25, fontWeight: FontWeight.w900)),
                      ),
                      Row(
                        children: [
                          barInfo('Lowongan Kerja', '10',  IconImageProvider(Icons.work_history_outlined, color: Colors.blue)),
                          barInfo('Lamaran Kerja', '10',  IconImageProvider(Icons.storage_outlined, color: Colors.red))
                        ],
                      ),
                      Container(
                        height: 5,
                      ),
                      Row(
                        children: [
                          barInfo('Perusahaan', '10',  IconImageProvider(Icons.business_outlined, color: Colors.orange)),
                          barInfo('Pencari Kerja', '10',  IconImageProvider(Icons.people_outline, color: Colors.green))
                        ],
                      ),
                    ]
                  )
                ),
                Container(
                  margin: EdgeInsets.only(bottom: 10),
                  alignment: Alignment.center,
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.start,
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Container(
                        margin: EdgeInsets.only(bottom: 5),
                        child: Text('Menu',  textAlign: TextAlign.center,
                                style: TextStyle(color: Color.fromARGB(255,17,62,108), fontSize: 20, fontWeight: FontWeight.w900)),
                      ),
                      barMenu(
                        Icon(LineAwesomeIcons.check_circle, color: Color.fromARGB(255,17,62,108)), 
                        'Verifikasi Kartu AK.1', 
                        Icon(LineAwesomeIcons.chevron_circle_right, color: Color.fromARGB(255, 51,178,124)),
                        context,
                        VerifikasiKartu()
                        // Navigator.push(
                        //   context,
                        //   MaterialPageRoute(builder: (context) => VerifikasiKartu()),
                        // )
                      ),
                      barMenu(
                        Icon(LineAwesomeIcons.briefcase, color: Color.fromARGB(255,17,62,108)), 
                        'Lowongan Kerja', 
                        Icon(LineAwesomeIcons.chevron_circle_right, color: Color.fromARGB(255, 51,178,124)),
                        context,
                        LowonganKerja()
                      ),
                    ]
                  )
                )
              ]
            )
          )
        )
      );
  }
}