package com.doan.scafe;

import com.google.gson.annotations.SerializedName;

public class SCafeMeta {


    public void Credentials (String userName , String userPassword) {

    }
}

class Credentials {
    String _token = GlobalVar.csrfToken;
    String username;
    String password;
    public Credentials(String username , String password){
        this.username = username;
        this.password = password;
    }
}

class LoggedDetail{

    @SerializedName("user_id")
    int user_id;
    @SerializedName("user_name")
    String user_name;
    @SerializedName("user_fullname")
    String user_fullname;
    @SerializedName("user_gender")
    String user_gender;
    @SerializedName("user_image")
    String user_image;
    @SerializedName("user_permission")
    String user_permission;
    @SerializedName("logged")
    int logged;

    void setGlobarVar(){
        GlobalVar.user_id = user_id;
        GlobalVar.user_name = user_name;
        GlobalVar.user_fullname = user_fullname;
        GlobalVar.user_gender = user_gender;
        GlobalVar.user_image = GlobalVar.baseBackendURL + user_image;
        GlobalVar.user_permission = user_permission;
        GlobalVar.logged = logged;
    }

}

class ChangePassword{
    String _token = GlobalVar.csrfToken;
    String oldPassword;
    String newPassword;
    public ChangePassword(String oldPassword , String newPassword) {
        this.oldPassword = oldPassword;
        this.newPassword = newPassword;
    }
}
class Room {
    @SerializedName("room_id")
    int room_id;
    @SerializedName("room_name")
    String room_name;
}

class Table {
    @SerializedName("atable_id")
    int atable_id;
    @SerializedName("atable_name")
    String atable_name;
    @SerializedName("invoice_id")
    int invoice_id;
    @SerializedName("final_price")
    int final_price;
    @SerializedName("status")
    int status;
}

class Category {
    @SerializedName("category_id")
    int category_id;
    @SerializedName("category_name")
    String category_name;
}

class Product implements Cloneable{
    @SerializedName("product_id")
    int product_id;
    @SerializedName("product_name")
    String product_name;
    @SerializedName("product_image")
    String product_image;
    @SerializedName("product_price")
    int product_price;

    int product_amount;

    @Override
    public Object clone() throws CloneNotSupportedException{
        return super.clone();
    }
}

class TableDetail {
    @SerializedName("invoice_id")
    int invoice_id;
    @SerializedName("table_id")
    int table_id;
    @SerializedName("discount_id")
    int discount_id;
    @SerializedName("discount_code")
    String discount_code;
    @SerializedName("discount_percent")
    int discount_percent;
    @SerializedName("discount_price")
    int discount_price;
    @SerializedName("total_price")
    int total_price;
    @SerializedName("final_price")
    int final_price;
    @SerializedName("status")
    int status;

}

class ProductInTable {
    @SerializedName("product_id")
    int product_id;
    @SerializedName("product_name")
    String product_name;
    @SerializedName("quantity")
    int quantity;
    @SerializedName("product_price")
    int product_price;
    @SerializedName("total_price")
    int total_price;

}
class Discount {
    @SerializedName("discount_id")
    int discount_id;
    @SerializedName("discount_code")
    String discount_code;
    @SerializedName("discount_percent")
    int discount_percent;
    @SerializedName("discount_des")
    String discount_des;
    @SerializedName("isSelected")
    int isSelected;
}
