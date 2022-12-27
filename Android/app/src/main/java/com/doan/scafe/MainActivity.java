package com.doan.scafe;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentPagerAdapter;
import androidx.viewpager.widget.ViewPager;

import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Toast;

import com.google.android.material.tabs.TabLayout;
import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;

import org.jetbrains.annotations.NotNull;


public class MainActivity extends AppCompatActivity {
    private TabLayout tabLayout;
    private ViewPager viewPager;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);


        Toolbar toolbar = findViewById(R.id.toolBar);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayShowTitleEnabled(false);

        tabLayout = findViewById(R.id.tabLayout);
        viewPager = findViewById(R.id.viewPager);
        GlobalVar.viewPager = viewPager;
        tabLayout.addTab(tabLayout.newTab().setText("Tất cả"));
        tabLayout.addTab(tabLayout.newTab().setText("Sử dụng"));
        tabLayout.addTab(tabLayout.newTab().setText("Còn trống"));


//        viewPager.setOffscreenPageLimit(0);
        viewPager.setAdapter(new FragmentPagerAdapter(getSupportFragmentManager(),tabLayout.getTabCount()) {
            @NonNull
            @NotNull
            @Override
            public Fragment getItem(int position) {
                Fragment fragment = null;
                GlobalVar.currentSelectedTab = position;
                GlobalVar.currentSelectedFragment = position;
                switch (position){
                    case 0:
                        fragment = new Tab1();
                        break;
                    case 1:
                        fragment = new Tab2();
                        break;
                    case 2:
                        fragment = new Tab3();
                        break;
                }

                return fragment;
            }



            @Override
            public int getCount() {
                return tabLayout.getTabCount();
            }
            @Override
            public CharSequence getPageTitle(int position) {
                return "OBJECT " + (position + 1);
            }


        });
        viewPager.addOnPageChangeListener(new TabLayout.TabLayoutOnPageChangeListener(tabLayout));
        tabLayout.addOnTabSelectedListener(new TabLayout.OnTabSelectedListener() {

            @Override
            public void onTabSelected(TabLayout.Tab tab) {
                viewPager.setCurrentItem(tab.getPosition());
                if (tab.getPosition() == 0) {
                    Tab1.updateData();
                }
                if (tab.getPosition() == 1) {
                    Tab2.updateData();
                }

                if (tab.getPosition() == 2) {
                    Tab3.updateData();
                }



            }

            @Override
            public void onTabUnselected(TabLayout.Tab tab) {

            }

            @Override
            public void onTabReselected(TabLayout.Tab tab) {

            }
        });

    }


    @Override
    protected void onResume() {
        super.onResume();

    }

    long lastPress;
    @Override
    public void onBackPressed() {
        long currentTime = System.currentTimeMillis();
        if(currentTime - lastPress > 5000){
            Toast.makeText(getBaseContext(), "Press back again to exist", Toast.LENGTH_LONG).show();
            lastPress = currentTime;
        }else{
            super.onBackPressed();
        }
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        super.onCreateOptionsMenu(menu);
        getMenuInflater().inflate(R.menu.main_activity_menu, menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle item selection
        switch (item.getItemId()) {
            case R.id.qrScanner:
                new IntentIntegrator(this).setCaptureActivity(QRScanActivity.class).setOrientationLocked(true).initiateScan(); // `this` is the current Activity
                return true;
            case R.id.accountSetting:
                Intent intent = new Intent(MainActivity.this, AccountSettingActivity.class);
                startActivity(intent);
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        IntentResult result = IntentIntegrator.parseActivityResult(requestCode, resultCode, data);
        if(result != null) {
            if(result.getContents() == null) {
                Toast.makeText(this, "Cancelled", Toast.LENGTH_LONG).show();
            } else {
                if (android.text.TextUtils.isDigitsOnly(result.getContents())){
                    GlobalVar.sCafeFunctions.getSeparateTable(Integer.parseInt(result.getContents()) , this);
                }
                else {
                    Toast.makeText(this, "Mã QR không hợp lệ" , Toast.LENGTH_LONG).show();
                }

            }
        } else {
            super.onActivityResult(requestCode, resultCode, data);
        }
    }
}