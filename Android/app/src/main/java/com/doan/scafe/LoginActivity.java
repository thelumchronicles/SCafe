package com.doan.scafe;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;

public class LoginActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.login_layout);

        GlobalVar.sCafeFunctions = new SCafeFunctions();


        Button btnLogin = findViewById(R.id.btnLogin);
        EditText txtUserName = findViewById(R.id.lbUserName);
        EditText txtUserPassword = findViewById(R.id.txtUserPassword);
        btnLogin.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GlobalVar.sCafeFunctions.login(LoginActivity.this, txtUserName.getText().toString() , txtUserPassword.getText().toString());
            }
        });
    }
}