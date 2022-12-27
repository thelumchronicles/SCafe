package com.doan.scafe;

import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import androidx.appcompat.app.AppCompatActivity;

public class PaySuccessful extends AppCompatActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.pay_successful);
        TextView txtFinalInvoiceName = findViewById(R.id.txtFinalInvoiceName);
        TextView txtFinalTotalPrice = findViewById(R.id.txtFinalTotalPrice);
        TextView txtTableName = findViewById(R.id.txtTableNamePay);
        txtFinalInvoiceName.setText(GlobalVar.currentSystemInvoiceName);
        txtFinalTotalPrice.setText(GlobalVar.currentTotalPrice + "đ");
        txtTableName.setText(GlobalVar.currentSystemTableName);
        Button button = findViewById(R.id.button);
        button.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GlobalVar.sCafeFunctions.updateDataFromFragments();
                finish();
            }
        });
    }

    @Override
    public void onBackPressed() {
        super.onBackPressed();
        GlobalVar.sCafeFunctions.updateDataFromFragments();
        finish();
    }
}
