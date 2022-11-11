import 'package:flutter/material.dart';
import 'package:line_awesome_flutter/line_awesome_flutter.dart';
import 'package:mobile/helpers/color.dart';
import 'package:mobile/helpers/services.dart';
import 'package:mobile/helpers/widget.dart';
import 'package:progress_dialog/progress_dialog.dart';

class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  bool showPassword = false;
  TextEditingController usernameController = TextEditingController();
  TextEditingController passwordController = TextEditingController();
  final _formKey = GlobalKey<FormState>();

  late ProgressDialog pr;

  void submitLogin() async{
    if (_formKey.currentState!.validate()) {
      pr.show();
      Services().postLogin(usernameController.text, passwordController.text).then((val) async {
        pr.hide();
        if (val['api_status'] == 1) {
          Navigator.pushNamedAndRemoveUntil(context, '/login/'+val['id_privilege'].toString(), (Route route)=>false);
        }else{
          showDialog(context: context, builder: (_) =>AlertDialog(
            title: Text('Something wrong'),
            content: Text('${val['api_message']}'),
            actions: <Widget>[ElevatedButton(onPressed: ()=>Navigator.pop(context), child: Text('Ok'))],
          ));
        }
      });
    }
  }
  @override
  Widget build(BuildContext context) {
    pr = ProgressDialog(context, type: ProgressDialogType.Normal);

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
    return Scaffold(
      // appBar: appBar('Login'),
      body: Container(
        
        // color: Colors.white,
        height: double.infinity,
        child: Column(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Expanded(
              flex: 3,
              child: Container(
                alignment: Alignment.center,
                decoration: BoxDecoration(
                    borderRadius: BorderRadius.only(bottomLeft: Radius.circular(50), bottomRight: Radius.circular(50)),
                    color: Color.fromARGB(255,39,82,159),
                  ),
                child: SingleChildScrollView(
                  child: Container(
                    padding: EdgeInsets.symmetric(horizontal: 20, vertical: 50),
                    child: Form(
                        key: _formKey,
                        child: Column(
                        
                          children: <Widget>[
                            Container(
                              margin: EdgeInsets.only(bottom: 30),
                              alignment: Alignment.center,
                              child:Text('Log In', 
                              style: TextStyle(color: Color.fromARGB(255, 255, 255, 255), fontSize: 25, fontWeight: FontWeight.w900)),
                            ),
                            Container(
                              margin: const EdgeInsets.only(top: 15, bottom: 15),
                              child:
                                TextFormField(
                                decoration: InputDecoration(
                                  enabledBorder: OutlineInputBorder(
                                    borderRadius: BorderRadius.circular(10),
                                    borderSide: BorderSide(
                                      color: Color.fromARGB(255, 220, 220, 220),
                                      width: 1,
                                    ),
                                  ),
                                  focusedBorder: OutlineInputBorder(
                                    borderRadius: BorderRadius.circular(15),
                                    borderSide: BorderSide(
                                      color: Colors.white,
                                    ),
                                  ),
                                  fillColor: Color.fromARGB(255, 246, 246, 246),
                                  filled: true,
                                  prefixIcon: Icon(LineAwesomeIcons.user),
                                  labelText: 'E-mail',
                                ),
                                controller: usernameController,
                                validator: (val){
                                  if (val!.isEmpty) {
                                    return 'E-mail is empty';
                                  }
                                  return null;
                                },
                                onEditingComplete: () => FocusScope.of(context).nextFocus(),
                              ),
                            ),
                            Container(
                              margin: const EdgeInsets.only(top: 15, bottom: 15),
                              child: TextFormField(
                                controller: passwordController,
                                validator: (val){
                                  if (val!.isEmpty) {
                                    return 'Password is empty';
                                  }
                                    return null;
                                },
                                obscureText: !showPassword,
                                decoration: InputDecoration(
                                  enabledBorder: OutlineInputBorder(
                                    borderRadius: BorderRadius.circular(10),
                                    borderSide: BorderSide(
                                      color: Color.fromARGB(255, 220, 220, 220),
                                      width: 1,
                                    ),
                                  ),
                                  focusedBorder: OutlineInputBorder(
                                    borderRadius: BorderRadius.circular(15),
                                    borderSide: BorderSide(
                                      color: Colors.blue,
                                    ),
                                  ),
                                  fillColor: Color.fromARGB(255, 246, 246, 246),
                                  filled: true,
                                  prefixIcon: Icon(LineAwesomeIcons.lock),
                                  suffixIcon: IconButton(
                                    icon: Icon(showPassword ? LineAwesomeIcons.eye : LineAwesomeIcons.eye_slash),
                                    onPressed: () async{
                                      // ignore: unnecessary_this
                                      this.setState(() {
                                        showPassword = !showPassword;
                                      });
                                    },
                                  ),
                                  // Icon(MdiIcons.eye),
                                  labelText: 'Password',
                                ),
                                onFieldSubmitted: (_) => {
                                  FocusScope.of(context).unfocus()
                                },
                              ),
                            ),
                          ]
                        )
                      ),
                  )
                ),
              ),
            ),
            Expanded(
              flex: 1,
              child: Container(
                width: double.infinity,
                margin: EdgeInsets.symmetric(horizontal: 10, vertical: 5),
                alignment: Alignment.bottomCenter,
                child: Column(
                  mainAxisAlignment:  MainAxisAlignment.end,
                  children: [
                    SizedBox(
                      width: double.infinity,
                      child: ElevatedButton(
                        child: Text('Log in', style: TextStyle(fontWeight: FontWeight.w900),), 
                        onPressed: (){
                          submitLogin();
                        },
                        style: ElevatedButton.styleFrom(
                          // elevation: 30,
                          shape:  RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(30.0),
                          ),
                          // shape: CircleBorder(),
                          padding: EdgeInsets.all(15),
                          primary: MyColor('primary'),
                          onPrimary: Colors.white,

                        ),
                      ),
                    ),
                    SizedBox(
                      width: double.infinity,
                      child: TextButton(onPressed: ()=>{}, child: Text('Daftar Baru'))
                    )
                  ],
                )
              ),
            )
          ],
        ),
      ),
    );
  }
}