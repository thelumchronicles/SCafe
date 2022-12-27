package com.doan.scafe;

import androidx.appcompat.app.AppCompatActivity;
import androidx.viewpager.widget.ViewPager;

public class GlobalVar extends AppCompatActivity {

    public static int currentSelectedTab = 0;
    public static String baseBackendURL = "http://192.168.1.5";
    public static String baseBackendURLApi = "http://192.168.1.5/api/";
    public static String csrfToken;
    public static SCafeFunctions sCafeFunctions;
    public static int user_id;
    public static String user_name;
    public static String user_fullname;
    public static String user_gender;
    public static String user_image;
    public static String user_permission;
    public static int logged;
    public static String currentSystemInvoiceName;
    public static int currentTotalPrice;
    public static int currentSystemTableID;
    public static String currentSystemTableName;
    public static int currentSystemCategoryID;
    public static String currentSystemCategoryName;
    public static int currentSystemInvoiceID;
    public static int currentSelectedFragment;
    public static ViewPager viewPager;
}
