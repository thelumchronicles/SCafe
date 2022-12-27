package com.doan.scafe;

import android.app.AlertDialog;
import android.graphics.Bitmap;
import android.graphics.BitmapShader;
import android.graphics.Canvas;
import android.graphics.Paint;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.squareup.picasso.Picasso;
import com.squareup.picasso.Transformation;


public class AccountSettingActivity extends AppCompatActivity {
    private TextView lbUserFullName;
    private TextView lbUserName;
    private TextView lbUserGender;
    private ImageView imageUser;
    private Button btnResetPassword;
    private EditText txtOldPassword;
    private EditText txtNewPassword;
    private EditText txtReNewPassword;
    private AlertDialog changePasswordDialog;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.account_setting);
        changePasswordDialog = new AlertDialog.Builder(AccountSettingActivity.this).setPositiveButton("OK", null).create();
        lbUserFullName = findViewById(R.id.lbUserFullName);
        lbUserName = findViewById(R.id.lbUserName);
        lbUserGender = findViewById(R.id.lbUserGender);
        imageUser = findViewById(R.id.imageUser);
        btnResetPassword = findViewById(R.id.btnResetPassword);
        txtOldPassword = findViewById(R.id.txtOldPassword);
        txtNewPassword = findViewById(R.id.txtNewPassword);
        txtReNewPassword = findViewById(R.id.txtReNewPassword);

        btnResetPassword.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GlobalVar.sCafeFunctions.ChangePassword(changePasswordDialog,txtOldPassword.getText().toString(),txtNewPassword.getText().toString(),txtReNewPassword.getText().toString());
            }
        });
        setVal();
    }

    void setVal(){
        Picasso.get().load(GlobalVar.user_image).transform(new CircleTransform()).into(imageUser);
        lbUserFullName.setText(GlobalVar.user_fullname);
        lbUserName.setText(GlobalVar.user_name);
        lbUserGender.setText(GlobalVar.user_gender);
    }



}

class CircleTransform implements Transformation {
    @Override
    public Bitmap transform(Bitmap source) {
        int size = Math.min(source.getWidth(), source.getHeight());

        int x = (source.getWidth() - size) / 2;
        int y = (source.getHeight() - size) / 2;

        Bitmap squaredBitmap = Bitmap.createBitmap(source, x, y, size, size);
        if (squaredBitmap != source) {
            source.recycle();
        }

        Bitmap bitmap = Bitmap.createBitmap(size, size, source.getConfig());

        Canvas canvas = new Canvas(bitmap);
        Paint paint = new Paint();
        BitmapShader shader = new BitmapShader(squaredBitmap, BitmapShader.TileMode.CLAMP, BitmapShader.TileMode.CLAMP);
        paint.setShader(shader);
        paint.setAntiAlias(true);

        float r = size/2f;
        canvas.drawCircle(r, r, r, paint);

        squaredBitmap.recycle();
        return bitmap;
    }

    @Override
    public String key() {
        return "circle";
    }
}
