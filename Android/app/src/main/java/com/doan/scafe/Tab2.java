package com.doan.scafe;

import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.constraintlayout.widget.ConstraintLayout;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import org.jetbrains.annotations.NotNull;

import java.util.ArrayList;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * A simple {@link Fragment} subclass.
 * Use the {@link Tab2#newInstance} factory method to
 * create an instance of this fragment.
 */
public class Tab2 extends Fragment {
    RecyclerView dataList;
    static ArrayList<Table> tables;
    static Frag2Adapter frag2Adapter;
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    public Tab2() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment Tab2.
     */
    // TODO: Rename and change types and number of parameters
    public static Tab2 newInstance(String param1, String param2) {
        Tab2 fragment = new Tab2();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            mParam1 = getArguments().getString(ARG_PARAM1);
            mParam2 = getArguments().getString(ARG_PARAM2);
        }
    }


    static void updateData(){
        GlobalVar.sCafeFunctions.getTables2(tables,frag2Adapter);
    }
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View rootView = inflater.inflate(R.layout.fragment_tab2 , container , false);
        rootView.findViewById(R.id.loadingPanel2).setVisibility(View.GONE);
//        GlobalVar.sCafeFunctions.setContext(rootView.getContext());
        dataList = rootView.findViewById(R.id.recyclerView2);
        tables = new ArrayList<>();
        frag2Adapter = new Frag2Adapter(rootView.getContext(), tables);
        GridLayoutManager gridLayoutManager = new GridLayoutManager(rootView.getContext(),2, GridLayoutManager.VERTICAL,false);
        dataList.setLayoutManager(gridLayoutManager);
        dataList.setAdapter(frag2Adapter);
        GlobalVar.sCafeFunctions.getRooms2(getContext(),tables,frag2Adapter);
        updateData();
        return rootView;
    }
    @Override
    public void onResume() {
        super.onResume();
        System.out.println("Tab2 Resumed");

    }
}

class Frag2Adapter extends RecyclerView.Adapter<Frag2Adapter.ViewHolder> {


    ArrayList<Table> tables;
    LayoutInflater inflater;

    public Frag2Adapter(Context ctx, ArrayList<Table> tables) {
        this.tables = tables;
        this.inflater = LayoutInflater.from(ctx);
    }


    @NonNull
    @NotNull
    @Override
    public ViewHolder onCreateViewHolder(@NonNull @NotNull ViewGroup parent, int viewType) {
        View view = inflater.inflate(R.layout.frag2_card, parent, false);
        return new ViewHolder(view);
    }

    @Override
    public void onBindViewHolder(@NonNull @NotNull ViewHolder holder, int position) {
        holder.tableBackground.setBackgroundResource(R.drawable.login_bg);
        holder.tableName.setTextColor(Color.parseColor("#FFFFFF"));
        holder.tablePrice.setTextColor(Color.parseColor("#FFFFFF"));
        if (tables.get(position).status == 0) {
            holder.tableBackground.setBackgroundResource(R.drawable.bg_table);
            holder.tableName.setTextColor(Color.parseColor("#1c1c1c"));
            holder.tablePrice.setTextColor(Color.parseColor("#1c1c1c"));
            holder.tablePrice.setText("");
        }
        if (tables.get(position).status == 1) {
            holder.tablePrice.setText(tables.get(position).final_price + "VNĐ");
        }
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                GlobalVar.currentSystemTableName = tables.get(position).atable_name;
                GlobalVar.currentSystemTableID = tables.get(position).atable_id;
                if (tables.get(position).status == 0){
                    GlobalVar.sCafeFunctions.sCafeHolderAPI.prepareTable(tables.get(position).atable_id).enqueue(new Callback<String>() {
                        @Override
                        public void onResponse(Call<String> call, Response<String> response) {
                            Intent orderedTable = new Intent(v.getContext(), OrderedTable.class);
                            v.getContext().startActivity(orderedTable);
                        }

                        @Override
                        public void onFailure(Call<String> call, Throwable t) {

                        }
                    });

                }
                else {
                    Intent orderedTable = new Intent(v.getContext(), OrderedTable.class);
                    v.getContext().startActivity(orderedTable);


                }
            }
        });

        holder.tableName.setText(tables.get(position).atable_name);

    }

    @Override
    public int getItemCount() {
        return tables.size();
    }

    public class ViewHolder extends RecyclerView.ViewHolder {
        TextView tableName;
        TextView tablePrice;
        ConstraintLayout tableBackground;

        public ViewHolder(@NonNull View itemView) {
            super(itemView);
            tableName = itemView.findViewById(R.id.txtTableName2);
            tablePrice = itemView.findViewById(R.id.txtTablePrice2);
            tableBackground = itemView.findViewById(R.id.tableBackground2);
        }
    }
}


